// src/components/HotelConfigForm.tsx

import { useState } from 'react';
import { hotelService } from '../api/hotelService';

interface Props {
  hotelId: number;
  onSuccess: () => void;
}

const opciones = {
  ESTANDAR: ['SENCILLA', 'DOBLE'],
  JUNIOR:   ['TRIPLE', 'CUADRUPLE'],
  SUITE:    ['SENCILLA', 'DOBLE', 'TRIPLE'],
} as const;

// Extraemos los tipos de las claves y valores de 'opciones'
type TipoHabitacion = keyof typeof opciones;
type Acomodacion   = typeof opciones[TipoHabitacion][number];

export function HotelConfigForm({ hotelId, onSuccess }: Props) {
  const [tipo, setTipo] = useState<TipoHabitacion>('ESTANDAR');
  const [acom, setAcom] = useState<Acomodacion>('SENCILLA');
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
      className="grid gap-3 md:grid-cols-4 mb-6"
    >
      {/* Select de tipo de habitación */}
      <select
        className="border rounded px-3 py-2"
        value={tipo}
        onChange={e => {
          const newTipo = e.target.value as TipoHabitacion;
          setTipo(newTipo);
          // Al cambiar el tipo, reinicio acomodación al primer valor válido
          setAcom(opciones[newTipo][0]);
        }}
      >
        {(Object.keys(opciones) as TipoHabitacion[]).map(k => (
          <option key={k} value={k}>
            {k}
          </option>
        ))}
      </select>

      {/* Select de acomodación */}
      <select
        className="border rounded px-3 py-2"
        value={acom}
        onChange={e => setAcom(e.target.value as Acomodacion)}
      >
        {opciones[tipo].map(a => (
          <option key={a} value={a}>
            {a}
          </option>
        ))}
      </select>

      {/* Input de cantidad */}
      <input
        type="number"
        min={1}
        className="border rounded px-3 py-2"
        value={cantidad}
        onChange={e => setCantidad(Number(e.target.value))}
      />

      {/* Botón de envío */}
      <button
        type="submit"
        className="bg-green-500 hover:bg-green-600 text-white rounded px-4 py-2 transition"
      >
        Agregar
      </button>
    </form>
  );
}
