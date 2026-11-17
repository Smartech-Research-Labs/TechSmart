import axios from 'axios';
import { installApiCache } from '@/lib/apiCache';

const api = axios.create({
  baseURL: '',
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json',
  },
});

// Same public-content cache as the global axios instance
installApiCache(api);

export default api;
