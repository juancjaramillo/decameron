import { Link } from 'react-router-dom';
import { Card } from './Card';
import { Hotel } from '../api/hotelService';

export function HotelCard({ hotel }: { hotel: Hotel }) {
  return (
    <Link to={`/hoteles/${hotel.id}`}>
      <Card>
        <h2 className="text-xl font-semibold mb-2">{hotel.nombre}</h2>
        <p className="text-gray-600 mb-1">Ciudad: {hotel.ciudad}</p>
        <p className="text-gray-600">Max. Habitaciones: {hotel.max_habitaciones}</p>
      </Card>
    </Link>
  );
}
