import { ref } from 'vue';

export type ToastType = 'success' | 'error' | 'warning' | 'info';

export interface Toast {
  id: number;
  type: ToastType;
  title: string;
  message?: string;
  duration?: number;
}

const toasts = ref<Toast[]>([]);
let toastIdCounter = 0;

export function useToast() {
  function show(
    type: ToastType,
    title: string,
    message?: string,
    duration: number = 5000
  ) {
    const toast: Toast = {
      id: ++toastIdCounter,
      type,
      title,
      message,
      duration,
    };

    toasts.value.push(toast);

    if (duration > 0) {
      setTimeout(() => {
        remove(toast.id);
      }, duration);
    }

    return toast.id;
  }

  function success(title: string, message?: string, duration?: number) {
    return show('success', title, message, duration);
  }

  function error(title: string, message?: string, duration?: number) {
    return show('error', title, message, duration);
  }

  function warning(title: string, message?: string, duration?: number) {
    return show('warning', title, message, duration);
  }

  function info(title: string, message?: string, duration?: number) {
    return show('info', title, message, duration);
  }

  function remove(id: number) {
    const index = toasts.value.findIndex((t) => t.id === id);
    if (index !== -1) {
      toasts.value.splice(index, 1);
    }
  }

  function clear() {
    toasts.value = [];
  }

  return {
    toasts,
    show,
    success,
    error,
    warning,
    info,
    remove,
    clear,
  };
}
