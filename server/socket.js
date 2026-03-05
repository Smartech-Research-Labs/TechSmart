require('dotenv').config();
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const axios = require('axios');

const app = express();
const server = http.createServer(app);

// Socket.IO configuration with CORS
const io = new Server(server, {
  cors: {
    origin: process.env.APP_URL || 'http://localhost:8000',
    credentials: true,
    methods: ['GET', 'POST']
  },
  transports: ['websocket', 'polling']
});

// Store active sessions and user connections
const activeSessions = new Map(); // sessionId -> Set of socketIds
const userSockets = new Map(); // userId -> socketId
const adminSockets = new Map(); // adminId -> socketId
const dmRooms = new Map(); // conversationId -> Set of socketIds
const onlineUsers = new Set(); // Set of userIds currently online

// Middleware for authentication
io.use((socket, next) => {
  const userId = socket.handshake.auth.userId;
  const token = socket.handshake.auth.token;
  
  // Store user info in socket
  socket.userId = userId;
  socket.token = token;
  
  next();
});

io.on('connection', (socket) => {
  console.log(`[Socket.IO] User connected: ${socket.id}`, {
    userId: socket.userId,
    timestamp: new Date().toISOString()
  });

  // Track user socket
  if (socket.userId) {
    userSockets.set(socket.userId, socket.id);
  }

  /**
   * Join a chat session room
   */
  socket.on('join-session', ({ sessionId }) => {
    socket.join(`session-${sessionId}`);
    
    // Track active session
    if (!activeSessions.has(sessionId)) {
      activeSessions.set(sessionId, new Set());
    }
    activeSessions.get(sessionId).add(socket.id);
    
    console.log(`[Socket.IO] User ${socket.id} joined session: ${sessionId}`);
    
    // Notify other participants in the session
    socket.to(`session-${sessionId}`).emit('user-joined', {
      socketId: socket.id,
      sessionId,
      timestamp: new Date().toISOString()
    });
  });

  /**
   * Leave a chat session room
   */
  socket.on('leave-session', ({ sessionId }) => {
    socket.leave(`session-${sessionId}`);
    
    if (activeSessions.has(sessionId)) {
      activeSessions.get(sessionId).delete(socket.id);
      if (activeSessions.get(sessionId).size === 0) {
        activeSessions.delete(sessionId);
      }
    }
    
    console.log(`[Socket.IO] User ${socket.id} left session: ${sessionId}`);
    
    socket.to(`session-${sessionId}`).emit('user-left', {
      socketId: socket.id,
      sessionId,
      timestamp: new Date().toISOString()
    });
  });

  /**
   * Send a message in a chat session
   */
  socket.on('send-message', async ({ sessionId, message }) => {
    console.log(`[Socket.IO] Message in session ${sessionId}:`, message);
    
    try {
      // Save message to database via API
      const response = await axios.post(
        `${process.env.API_BASE_URL}/user/chat/sessions/${sessionId}/messages`,
        {
          message,
          user_id: socket.userId,
          is_from_admin: false
        },
        {
          headers: {
            'Authorization': `Bearer ${socket.token}`,
            'Content-Type': 'application/json'
          }
        }
      );

      const savedMessage = response.data.message;

      // Broadcast to all users in the session
      io.to(`session-${sessionId}`).emit('new-message', {
        ...savedMessage,
        timestamp: new Date().toISOString()
      });

      // Notify admins about new message (if online)
      notifyAdmins('new-user-message', {
        sessionId,
        message: savedMessage,
        userId: socket.userId
      });

    } catch (error) {
      console.error('[Socket.IO] Error saving message:', error.message);
      socket.emit('message-error', {
        error: 'Failed to send message',
        sessionId
      });
    }
  });

  /**
   * Typing indicator
   */
  socket.on('typing', ({ sessionId, isTyping }) => {
    socket.to(`session-${sessionId}`).emit('typing-status', {
      sessionId,
      isTyping,
      userId: socket.userId,
      timestamp: new Date().toISOString()
    });
  });

  /**
   * Admin-specific: Send message as admin
   */
  socket.on('admin-send-message', async ({ sessionId, message, adminId }) => {
    console.log(`[Socket.IO] Admin ${adminId} message in session ${sessionId}`);
    
    try {
      const response = await axios.post(
        `${process.env.API_BASE_URL}/admin/chat/sessions/${sessionId}/messages`,
        {
          message,
          admin_id: adminId,
          is_from_admin: true
        },
        {
          headers: {
            'Authorization': `Bearer ${socket.token}`,
            'Content-Type': 'application/json'
          }
        }
      );

      const savedMessage = response.data.message;

      io.to(`session-${sessionId}`).emit('new-message', {
        ...savedMessage,
        timestamp: new Date().toISOString()
      });

    } catch (error) {
      console.error('[Socket.IO] Error saving admin message:', error.message);
      socket.emit('message-error', {
        error: 'Failed to send message',
        sessionId
      });
    }
  });

  /**
   * Admin-specific: Assign session to admin
   */
  socket.on('assign-session', ({ sessionId, adminId }) => {
    io.to(`session-${sessionId}`).emit('session-assigned', {
      sessionId,
      adminId,
      timestamp: new Date().toISOString()
    });
    
    console.log(`[Socket.IO] Session ${sessionId} assigned to admin ${adminId}`);
  });

  /**
   * Register as admin (for receiving notifications)
   */
  socket.on('register-admin', ({ adminId }) => {
    adminSockets.set(adminId, socket.id);
    socket.join('admins');
    console.log(`[Socket.IO] Admin ${adminId} registered with socket ${socket.id}`);
  });

  // =============================================
  // Direct Messaging & Presence
  // =============================================

  /**
   * Register user for DM and presence
   */
  socket.on('dm-register', ({ userId }) => {
    if (!userId) return;
    socket.userId = userId;
    userSockets.set(userId, socket.id);
    onlineUsers.add(userId);

    // Broadcast presence to all connected users
    socket.broadcast.emit('user-presence', { userId, isOnline: true });
    console.log(`[Socket.IO] User ${userId} online (dm-register)`);
  });

  /**
   * Join a DM conversation room
   */
  socket.on('dm-join', ({ conversationId }) => {
    if (!conversationId) return;
    socket.join(`dm-${conversationId}`);
    if (!dmRooms.has(conversationId)) {
      dmRooms.set(conversationId, new Set());
    }
    dmRooms.get(conversationId).add(socket.id);
    console.log(`[Socket.IO] User ${socket.userId} joined DM room: ${conversationId}`);
  });

  /**
   * Send a direct message
   */
  socket.on('dm-send', ({ conversationId, receiverId, message }) => {
    if (!conversationId || !message) return;

    // Emit to conversation room (both participants if in room)
    socket.to(`dm-${conversationId}`).emit('dm-message', message);

    // Also emit directly to receiver socket if they are not in the room
    const receiverSocketId = userSockets.get(receiverId);
    if (receiverSocketId) {
      const receiverSocket = io.sockets.sockets.get(receiverSocketId);
      if (receiverSocket && !receiverSocket.rooms.has(`dm-${conversationId}`)) {
        receiverSocket.emit('dm-message', message);
      }

      // If receiver is in the room, auto-mark as delivered
      if (dmRooms.has(conversationId) && dmRooms.get(conversationId).has(receiverSocketId)) {
        socket.emit('dm-status-update', { messageId: message.id, status: 'delivered' });
      }
    }

    console.log(`[Socket.IO] DM sent in conversation ${conversationId} from ${socket.userId} to ${receiverId}`);
  });

  /**
   * Mark messages as read in a DM conversation
   */
  socket.on('dm-read', ({ conversationId, userId }) => {
    if (!conversationId) return;
    // Notify the other participant that messages were read
    socket.to(`dm-${conversationId}`).emit('dm-status-update', {
      conversationId,
      readBy: userId,
      status: 'read',
    });
    console.log(`[Socket.IO] DM read: conversation ${conversationId} by user ${userId}`);
  });

  /**
   * DM typing indicator
   */
  socket.on('dm-typing', ({ conversationId, userName, isTyping }) => {
    if (!conversationId) return;
    socket.to(`dm-${conversationId}`).emit('dm-typing', {
      conversationId,
      userName,
      isTyping,
    });
  });

  /**
   * Handle disconnection
   */
  socket.on('disconnect', () => {
    console.log(`[Socket.IO] User disconnected: ${socket.id}`);
    
    // Clean up user socket tracking & broadcast offline presence
    if (socket.userId) {
      userSockets.delete(socket.userId);
      onlineUsers.delete(socket.userId);
      socket.broadcast.emit('user-presence', { userId: socket.userId, isOnline: false });
    }
    
    // Clean up admin socket tracking
    for (const [adminId, socketId] of adminSockets.entries()) {
      if (socketId === socket.id) {
        adminSockets.delete(adminId);
        break;
      }
    }
    
    // Clean up active sessions
    for (const [sessionId, sockets] of activeSessions.entries()) {
      sockets.delete(socket.id);
      if (sockets.size === 0) {
        activeSessions.delete(sessionId);
      }
    }

    // Clean up DM rooms
    for (const [convId, sockets] of dmRooms.entries()) {
      sockets.delete(socket.id);
      if (sockets.size === 0) {
        dmRooms.delete(convId);
      }
    }
  });

  /**
   * Handle connection errors
   */
  socket.on('error', (error) => {
    console.error('[Socket.IO] Socket error:', error);
  });
});

/**
 * Notify all online admins
 */
function notifyAdmins(event, data) {
  io.to('admins').emit(event, data);
}

// Health check endpoint
app.get('/health', (req, res) => {
  res.json({
    status: 'ok',
    uptime: process.uptime(),
    activeSessions: activeSessions.size,
    connectedUsers: userSockets.size,
    connectedAdmins: adminSockets.size,
    onlineUsers: onlineUsers.size,
    activeDMRooms: dmRooms.size,
    timestamp: new Date().toISOString()
  });
});

// Start server
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
  console.log(`[Socket.IO] Server running on port ${PORT}`);
  console.log(`[Socket.IO] CORS enabled for: ${process.env.APP_URL}`);
  console.log(`[Socket.IO] Health check: http://localhost:${PORT}/health`);
});

// Graceful shutdown
process.on('SIGTERM', () => {
  console.log('[Socket.IO] SIGTERM received, shutting down gracefully...');
  server.close(() => {
    console.log('[Socket.IO] Server closed');
    process.exit(0);
  });
});

process.on('SIGINT', () => {
  console.log('[Socket.IO] SIGINT received, shutting down gracefully...');
  server.close(() => {
    console.log('[Socket.IO] Server closed');
    process.exit(0);
  });
});
