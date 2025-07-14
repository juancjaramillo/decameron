import api from './client';

export interface AuthResponse {
  token: string;
}

/**
 * Nunca a /login ni al middleware web de Sanctum.
 */
export function loginAPI(email: string, password: string) {
  return api.post<AuthResponse>('/auth/token', { email, password });
}
