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

  /**
   * Handle disconnection
   */
  socket.on('disconnect', () => {
    console.log(`[Socket.IO] User disconnected: ${socket.id}`);
    
    // Clean up user socket tracking
    if (socket.userId) {
      userSockets.delete(socket.userId);
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
