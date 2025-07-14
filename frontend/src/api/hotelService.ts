// src/api/hotelService.ts
import api from './client';

export interface Hotel {
  id: number;
  nombre: string;
  direccion: string;
  ciudad: string;
  nit: string;
  max_habitaciones: number;
}

export interface Config {
  id: number;
  tipo_habitacion: 'ESTANDAR' | 'JUNIOR' | 'SUITE';
  acomodacion: string;
  cantidad: number;
}

export function listHoteles() {
  return api.get<Hotel[]>('/hoteles');
}

export function getHotel(id: number) {
  return api.get<Hotel>(`/hoteles/${id}`);
}

export function createHotel(data: Partial<Hotel>) {
  return api.post<Hotel>('/hoteles', data);
}

export function updateHotel(id: number, data: Partial<Hotel>) {
  return api.put<Hotel>(`/hoteles/${id}`, data);
}

export function deleteHotel(id: number) {
  return api.delete<void>(`/hoteles/${id}`);
}

export function listConfigs(hotelId: number) {
  return api.get<Config[]>(`/hoteles/${hotelId}/configuraciones`);
}

export function createConfig(hotelId: number, data: Omit<Config,'id'>) {
  return api.post<Config>(`/hoteles/${hotelId}/configuraciones`, data);
}

export function deleteConfig(id: number) {
  return api.delete<void>(`/configuraciones/${id}`);
}
