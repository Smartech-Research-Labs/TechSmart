/**
 * Notification Sound Composable
 * Plays chime sounds when notifications arrive
 */

import { ref } from 'vue';

// Base64 encoded notification chime sound (short pleasant chime)
const NOTIFICATION_CHIME_BASE64 = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2teleVMwO6Xp6qtxOwgxodXz2YlVLDam3e7dnFgSDkKZ3fXgiEoWBTWa3fLjhj4ABCGK1fHmhDYAABl/0fDqhC8AABBwx+/siCsAAAdmwu3tjyoAAARes+zsly4AAANZrerstTgAAANYq+rrt0AAAANZK+nqt0IAAANbLOnouEYAAANdL+jouUgAAANeL+jouUoAAANfL+jouUsAAANfL+jouUsAAANfL+jouUsAAANfL+jouUsAAANfL+jouUsAAANfL+jouUsAAANfL+jouUsAAANfL+jouUsAAANeL+jouUoAAANdL+jouUgAAANcLOnouEYAAANaKunqt0QAAANYKerrtkEAAAFVpurrszgAAABRn+vstjAAAABMmO3slCoAAABFkO7rjCYAAD0+h+/oiCEAACQyfu/ohR0AABcneO/phBoAAAwgcu/shBgAAAUZbO/uhRYAAAASZ+/whRQAAAAPZO/xhRMAAAANYu/yhRIAAAAMYO/zhREAAAALX+/0hREAAAAKXu/1hREAAAAKXu/1hBEAAAAJXe/2hBEAAAAJXe/2hBAAAAAJXO/3hBAAAAAJXO/3gxAAAgIJXO/3gw8AAQIJWu/4gw4AAQMJWe/4gg4AAgMKWO/5gg0AAgQKV+/5gQ0AAwQLVu/6gQwAAwULVe/6gAwABAYMVO/7fwsABAcMU+77fwoABQgNU+77fgoABgkOUu78fQkABwoOU+78fQgACAsQUu78ewcACQ0RUe77egYACg4SUO77eQUADA8TT+77eAQADRETTu77dwMADhIUT+77dQIAEBMVTu76dAEAERQWT+76cwAAExYYT+76cgAAFBcZUO76cQAAFhkaUO76cAAAFxscUe/5bwAAGBwdUe/5bgAAGh0eUu/5bQAAGx4fU+/5bAAAHB8gU+/4bAAAHSAhVO/4awAAHyEjVe/4agAAICIkVe/4aQAAISMlVu/4aAAAIyQmV+/3ZwAAJCUnV+/3ZgAAJSYoWO/3ZQAAJ6YpWe/2ZAAAKKcqWe/2YwAAKagqWu/2YgAAK6krW+/1YQAALKosW+/1YAAALaosPErvNVYAAC6rLT1K7zRVAAAvqy4+Su8zVAAAMKsuPkrtMlQAADGsLz9K7TJUAAA=';

// Alternative notification sounds
const NOTIFICATION_SOUNDS = {
  chime: NOTIFICATION_CHIME_BASE64,
  // Shorter beep sound
  beep: 'data:audio/wav;base64,UklGRl9vT19teleXNTUyM5ODBUhHT19TVllyFBAQMm44ESkuA1tmdHFjWlpddHl3b2RdXWNpaGVgXV1gZGRiYGBiZGVkY2NkZWZlZGRkZWVlZGRkZGRkZGRk',
};

export function useNotificationSound() {
  const audioContext = ref<AudioContext | null>(null);
  const audioEnabled = ref(true);
  const volume = ref(0.5);

  // Initialize audio context on first interaction
  function initAudio() {
    if (!audioContext.value) {
      try {
        audioContext.value = new (window.AudioContext || (window as any).webkitAudioContext)();
      } catch (e) {
        // Web Audio API not supported in this browser
      }
    }
  }

  // Play notification chime sound
  async function playChime() {
    if (!audioEnabled.value) return;

    try {
      // Create a simple audio element and play
      const audio = new Audio(NOTIFICATION_CHIME_BASE64);
      audio.volume = volume.value;
      await audio.play();
    } catch (e) {
      // Fallback: use Web Audio API to generate a simple chime
      playGeneratedChime();
    }
  }

  // Generate and play a synthetic chime sound
  function playGeneratedChime() {
    initAudio();
    if (!audioContext.value) return;

    const ctx = audioContext.value;
    const currentTime = ctx.currentTime;

    // Create oscillator for the main tone
    const oscillator = ctx.createOscillator();
    const gainNode = ctx.createGain();

    oscillator.connect(gainNode);
    gainNode.connect(ctx.destination);

    // Pleasant chime frequency (G5 note - 783.99 Hz)
    oscillator.type = 'sine';
    oscillator.frequency.setValueAtTime(783.99, currentTime);
    oscillator.frequency.exponentialRampToValueAtTime(659.25, currentTime + 0.1);

    // Envelope for natural sound decay
    gainNode.gain.setValueAtTime(volume.value * 0.3, currentTime);
    gainNode.gain.exponentialRampToValueAtTime(0.001, currentTime + 0.5);

    oscillator.start(currentTime);
    oscillator.stop(currentTime + 0.5);

    // Add harmonics for richer sound
    const harmonic = ctx.createOscillator();
    const harmonicGain = ctx.createGain();
    harmonic.connect(harmonicGain);
    harmonicGain.connect(ctx.destination);

    harmonic.type = 'sine';
    harmonic.frequency.setValueAtTime(1567.98, currentTime);
    harmonic.frequency.exponentialRampToValueAtTime(1318.51, currentTime + 0.08);

    harmonicGain.gain.setValueAtTime(volume.value * 0.1, currentTime);
    harmonicGain.gain.exponentialRampToValueAtTime(0.001, currentTime + 0.3);

    harmonic.start(currentTime);
    harmonic.stop(currentTime + 0.3);
  }

  // Play message notification (slightly different tone)
  function playMessageChime() {
    initAudio();
    if (!audioContext.value) return;
    if (!audioEnabled.value) return;

    const ctx = audioContext.value;
    const currentTime = ctx.currentTime;

    // Two-tone notification (like a message receive sound)
    const notes = [659.25, 783.99]; // E5, G5

    notes.forEach((freq, index) => {
      const osc = ctx.createOscillator();
      const gain = ctx.createGain();
      osc.connect(gain);
      gain.connect(ctx.destination);

      osc.type = 'sine';
      osc.frequency.value = freq;

      const startTime = currentTime + index * 0.15;
      gain.gain.setValueAtTime(volume.value * 0.2, startTime);
      gain.gain.exponentialRampToValueAtTime(0.001, startTime + 0.3);

      osc.start(startTime);
      osc.stop(startTime + 0.3);
    });
  }

  // Toggle sound on/off
  function toggleSound() {
    audioEnabled.value = !audioEnabled.value;
    if (audioEnabled.value) {
      playChime(); // Play test chime when enabling
    }
    return audioEnabled.value;
  }

  // Set volume (0-1)
  function setVolume(newVolume: number) {
    volume.value = Math.max(0, Math.min(1, newVolume));
  }

  return {
    playChime,
    playMessageChime,
    playGeneratedChime,
    toggleSound,
    setVolume,
    audioEnabled,
    volume,
  };
}
