import { useEffect, useState } from 'react';
import { hotelService, Hotel } from '../api/hotelService';
import { HotelCard } from '../components/HotelCard';
import { Spinner } from '../components/Spinner';
import { Header } from '../components/Header';

export function HotelesList() {
  const [hoteles, setHoteles] = useState<Hotel[] | null>(null);

  useEffect(() => {
    hotelService.listar().then(r => setHoteles(r.data));
  }, []);

  return (
    <div>
      <Header />
      <div className="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {hoteles === null ? (
          <Spinner />
        ) : hoteles.length === 0 ? (
          <p className="text-center col-span-full">No hay hoteles aún.</p>
        ) : (
          hoteles.map(h => <HotelCard key={h.id} hotel={h} />)
        )}
      </div>
    </div>
  );
}
