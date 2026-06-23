import axios from 'axios';

const instance = axios.create({
  headers: {
    'X-Requested-With': 'XMLHttpRequest'
  }
});

const getCsrf = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

instance.interceptors.request.use((config) => {
  const token = getCsrf();
  if (token) config.headers['X-CSRF-TOKEN'] = token;
  return config;
}, (err) => Promise.reject(err));

export const api = {
  instance,
  get: (url, opts = {}) => instance.get(url, opts),
  post: (url, data, opts = {}) => instance.post(url, data, opts),
  put: (url, data, opts = {}) => instance.put(url, data, opts),
  delete: (url, opts = {}) => instance.delete(url, opts)
};

export default api;
