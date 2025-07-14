import { api } from './client';
export interface Hotel { id:number; nombre:string; ciudad:string; nit:string; max_habitaciones:number; }
export interface Config { id:number; tipo_habitacion:string; acomodacion:string; cantidad:number; }
export const hotelService = {
  listar: () => api.get<Hotel[]>('/hoteles'),
  obtener: (id:number) => api.get<Hotel>(`/hoteles/${id}`),
  crear: (data:Partial<Hotel>) => api.post<Hotel>('/hoteles', data),
  actualizar: (id:number, data:Partial<Hotel>) => api.put<Hotel>(`/hoteles/${id}`, data),
  eliminar: (id:number) => api.delete(`/hoteles/${id}`),
  listarConfigs: (hotelId:number) => api.get<Config[]>(`/hoteles/${hotelId}/configuraciones`),
  crearConfig: (hotelId:number, data:Omit<Config,'id'>) => api.post<Config>(`/hoteles/${hotelId}/configuraciones`, data),
  eliminarConfig: (hotelId:number, id:number) => api.delete(`/hoteles/${hotelId}/configuraciones/${id}`),
};