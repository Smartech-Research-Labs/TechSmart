import { ref, onUnmounted } from 'vue';
import { io, type Socket } from 'socket.io-client';

const socket = ref<Socket | null>(null);
const isConnected = ref(false);

export function useSocket() {
  function connect(userId?: number) {
    if (socket.value?.connected) {
      return socket.value;
    }

    // Create socket connection
    socket.value = io(import.meta.env.VITE_SOCKET_URL || 'http://localhost:3000', {
      auth: {
        userId,
        token: localStorage.getItem('token'),
      },
      reconnection: true,
      reconnectionDelay: 1000,
      reconnectionDelayMax: 5000,
      reconnectionAttempts: 5,
    });

    // Connection events
    socket.value.on('connect', () => {
      isConnected.value = true;
      console.log('Socket.IO connected:', socket.value?.id);
    });

    socket.value.on('disconnect', (reason) => {
      isConnected.value = false;
      console.log('Socket.IO disconnected:', reason);
    });

    socket.value.on('connect_error', (error) => {
      console.error('Socket.IO connection error:', error);
    });

    socket.value.on('reconnect', (attemptNumber) => {
      console.log('Socket.IO reconnected after', attemptNumber, 'attempts');
    });

    socket.value.on('reconnect_failed', () => {
      console.error('Socket.IO reconnection failed');
    });

    return socket.value;
  }

  function disconnect() {
    if (socket.value) {
      socket.value.disconnect();
      socket.value = null;
      isConnected.value = false;
    }
  }

  function emit(event: string, data?: any) {
    if (!socket.value?.connected) {
      console.warn('Socket not connected, cannot emit:', event);
      return false;
    }
    socket.value.emit(event, data);
    return true;
  }

  function on(event: string, handler: (...args: any[]) => void) {
    if (!socket.value) {
      console.warn('Socket not initialized');
      return;
    }
    socket.value.on(event, handler);
  }

  function off(event: string, handler?: (...args: any[]) => void) {
    if (!socket.value) return;
    if (handler) {
      socket.value.off(event, handler);
    } else {
      socket.value.off(event);
    }
  }

  function joinRoom(room: string) {
    emit('join-room', { room });
  }

  function leaveRoom(room: string) {
    emit('leave-room', { room });
  }

  // Cleanup on component unmount
  onUnmounted(() => {
    // Don't disconnect automatically - let chat store manage connection
  });

  return {
    socket,
    isConnected,
    connect,
    disconnect,
    emit,
    on,
    off,
    joinRoom,
    leaveRoom,
  };
}
