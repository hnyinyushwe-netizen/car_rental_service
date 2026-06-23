// axios wrapper for reusable API calls
import axios from 'axios';

const api = axios.create({
  baseURL: window.APP_API_BASE_URL || '/',
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json',
  },
  withCredentials: true,
});

const tokenMeta = document.head.querySelector('meta[name="csrf-token"]');
if (tokenMeta) {
  api.defaults.headers.common['X-CSRF-TOKEN'] = tokenMeta.content;
}

export default {
  get(url, config = {}) { return api.get(url, config).then(r => r.data); },
  post(url, data = {}, config = {}) { return api.post(url, data, config).then(r => r.data); },
  put(url, data = {}, config = {}) { return api.put(url, data, config).then(r => r.data); },
  delete(url, config = {}) { return api.delete(url, config).then(r => r.data); },
  instance: api,
};
