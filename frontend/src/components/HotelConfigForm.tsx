import React, { useState } from 'react';
import { createConfig, Config } from '../api/hotelService';

interface Props {
  hotelId: number;
  maxHabitaciones: number;
  onCreate: (cfg: Config) => void;
}

export default function HotelConfigForm({ hotelId, maxHabitaciones, onCreate }: Props) {
  const [tipo, setTipo] = useState<'ESTANDAR'|'JUNIOR'|'SUITE'>('ESTANDAR');
  const [acom, setAcom] = useState('');
  const [cant, setCant] = useState(1);

  const opcionesAcomod = {
    ESTANDAR: ['SENCILLA','DOBLE'],
    JUNIOR:   ['TRIPLE','CUADRUPLE'],
    SUITE:    ['SENCILLA','DOBLE','TRIPLE']
  }[tipo];

  function submit(e: React.FormEvent) {
    e.preventDefault();
    createConfig(hotelId, { tipo_habitacion: tipo, acomodacion: acom, cantidad: cant })
      .then(({ data }) => {
        onCreate(data);
        setCant(1);
      });
  }

  return (
    <form onSubmit={submit} className="mt-4 space-y-2">
      <div className="flex space-x-2">
        <select
          value={tipo}
          onChange={e => setTipo(e.target.value as any)}
          className="border p-1 rounded"
        >
          {Object.keys(opcionesAcomod).map(t => (
            <option key={t} value={t}>{t}</option>
          ))}
        </select>

        <select
          value={acom}
          onChange={e => setAcom(e.target.value)}
          className="border p-1 rounded"
        >
          <option value="">— Acomodación —</option>
          {opcionesAcomod.map(a => (
            <option key={a} value={a}>{a}</option>
          ))}
        </select>

        <input
          type="number"
          min={1}
          max={maxHabitaciones}
          value={cant}
          onChange={e => setCant(+e.target.value)}
          className="w-20 border p-1 rounded"
        />

        <button type="submit" className="px-3 bg-blue-600 text-white rounded">
          Agregar
        </button>
      </div>
    </form>
  );
}
