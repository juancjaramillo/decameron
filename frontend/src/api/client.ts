import axios from 'axios';

export const TOKEN_KEY = 'api_token';

const api = axios.create({
  baseURL: process.env.REACT_APP_API_URL,  
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
  withCredentials: false,  
});

api.interceptors.request.use(config => {
  const token = localStorage.getItem(TOKEN_KEY);
  if (token && config.headers) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;
