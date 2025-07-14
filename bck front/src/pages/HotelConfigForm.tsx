import { useState } from 'react';
import { hotelService } from '../api/hotelService';

// 1) Definimos los posibles tipos de habitación
type TipoHabitacion = 'ESTANDAR' | 'JUNIOR' | 'SUITE';

// 2) Acomodaciones válidas por tipo
type Acomodacion = 'SENCILLA' | 'DOBLE' | 'TRIPLE' | 'CUADRUPLE';

// 3) Estructura de nuestro objeto de opciones
const opciones: Record<TipoHabitacion, readonly Acomodacion[]> = {
  ESTANDAR: ['SENCILLA', 'DOBLE'],
  JUNIOR:   ['TRIPLE', 'CUADRUPLE'],
  SUITE:    ['SENCILLA', 'DOBLE', 'TRIPLE'],
};

interface Props {
  hotelId: number;
  onSuccess: () => void;
}

export function HotelConfigForm({ hotelId, onSuccess }: Props) {
  // tipamos el estado con nuestros tipos
  const [tipo, setTipo] = useState<TipoHabitacion>('ESTANDAR');
  const [acom, setAcom] = useState<Acomodacion>(opciones['ESTANDAR'][0]);
  const [cantidad, setCantidad] = useState<number>(1);

  return (
    <form
      onSubmit={async e => {
        e.preventDefault();
        await hotelService.crearConfig(hotelId, {
          tipo_habitacion: tipo,
          acomodacion: acom,
          cantidad,
        });
        onSuccess();
      }}
      className="space-y-2"
    >
      {/* Selector de tipo de habitación */}
      <select
        value={tipo}
        onChange={e => {
          // TS sabe que e.target.value es TipoHabitacion
          const nuevoTipo = e.target.value as TipoHabitacion;
          setTipo(nuevoTipo);
          // actualizamos acomodación al primer valor válido
          setAcom(opciones[nuevoTipo][0]);
        }}
        className="border rounded px-3 py-2"
      >
        {(Object.keys(opciones) as TipoHabitacion[]).map(k => (
          <option key={k} value={k}>
            {k}
          </option>
        ))}
      </select>

      {/* Selector de acomodación, solo las válidas para el tipo */}
      <select
        value={acom}
        onChange={e => setAcom(e.target.value as Acomodacion)}
        className="border rounded px-3 py-2"
      >
        {opciones[tipo].map(a => (
          <option key={a} value={a}>
            {a}
          </option>
        ))}
      </select>

      {/* Cantidad */}
      <input
        type="number"
        min={1}
        value={cantidad}
        onChange={e => setCantidad(Number(e.target.value))}
        className="border rounded px-3 py-2"
      />

      <button
        type="submit"
        className="bg-blue-500 text-white px-4 py-1 rounded"
      >
        Agregar
      </button>
    </form>
  );
}
