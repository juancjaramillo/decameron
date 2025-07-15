import api from './client';
import { AxiosResponse } from 'axios';

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

// Interfaz para la respuesta listHoteles
interface ListHotelesResponse {
  data: Hotel[];
}

// Ahora listHoteles devuelve un wrapper con `data: Hotel[]`
export function listHoteles(): Promise<AxiosResponse<ListHotelesResponse>> {
  return api.get<ListHotelesResponse>('/hoteles');
}

export function getHotel(id: number): Promise<AxiosResponse<Hotel>> {
  return api.get<Hotel>(`/hoteles/${id}`);
}

export function createHotel(data: Partial<Hotel>): Promise<AxiosResponse<Hotel>> {
  return api.post<Hotel>('/hoteles', data);
}

export function updateHotel(id: number, data: Partial<Hotel>): Promise<AxiosResponse<Hotel>> {
  return api.put<Hotel>(`/hoteles/${id}`, data);
}

export function deleteHotel(id: number): Promise<AxiosResponse<void>> {
  return api.delete<void>(`/hoteles/${id}`);
}

export function listConfigs(hotelId: number): Promise<AxiosResponse<Config[]>> {
  return api.get<Config[]>(`/hoteles/${hotelId}/configuraciones`);
}

export function createConfig(
  hotelId: number,
  data: Omit<Config, 'id'>
): Promise<AxiosResponse<Config>> {
  return api.post<Config>(`/hoteles/${hotelId}/configuraciones`, data);
}

export function deleteConfig(id: number): Promise<AxiosResponse<void>> {
  return api.delete<void>(`/configuraciones/${id}`);
}
