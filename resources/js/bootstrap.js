import axios from 'axios';
import userManager from './utils/userManager';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// ✅ Add X-User-ID header to all requests
// Fallback to "0" if userManager is not available
window.axios.interceptors.request.use((config) => {
  try {
    const userId = userManager.getUserId() || '0';
    config.headers['X-User-ID'] = userId;
  } catch (error) {
    // Fallback to "0" for testing
    config.headers['X-User-ID'] = '0';
  }
  return config;
}, (error) => {
  return Promise.reject(error);
});
