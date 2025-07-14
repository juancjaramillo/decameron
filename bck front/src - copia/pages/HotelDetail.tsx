import { useParams } from 'react-router-dom';
import { useEffect, useState } from 'react';
import { AxiosResponse } from 'axios';
import { hotelService, Hotel, Config } from '../api/hotelService';
import { HotelConfigForm } from '../components/HotelConfigForm';
import { Card } from '../components/Card';
import { Spinner } from '../components/Spinner';
import { Header } from '../components/Header';

export function HotelDetail() {
  const { id } = useParams<{ id: string }>();
  const [hotel, setHotel] = useState<Hotel | null>(null);
  const [configs, setConfigs] = useState<Config[] | null>(null);

  useEffect(() => {
    if (!id) return;

    hotelService
      .obtener(+id)
      .then((response: AxiosResponse<Hotel>) => setHotel(response.data));

    hotelService
      .listarConfigs(+id)
      .then((response: AxiosResponse<Config[]>) => setConfigs(response.data));
  }, [id]);

  if (!hotel || configs === null) {
    return <Spinner />;
  }

  return (
    <div>
      <Header />
      <div className="p-6 space-y-6">
        <Card>
          <h1 className="text-2xl font-bold">{hotel.nombre}</h1>
          <p className="text-gray-600">Ciudad: {hotel.ciudad}</p>
        </Card>

        <HotelConfigForm
          hotelId={hotel.id}
          onSuccess={() =>
            hotelService
              .listarConfigs(hotel.id)
              .then((response: AxiosResponse<Config[]>) =>
                setConfigs(response.data)
              )
          }
        />

        <div className="grid gap-4">
          {configs.length === 0 ? (
            <p>No hay configuraciones aún.</p>
          ) : (
            configs.map(c => (
              <Card
                key={c.id}
                className="flex justify-between items-center"
              >
                <div>
                  {c.tipo_habitacion} — {c.acomodacion}: {c.cantidad}
                </div>
                <button
                  onClick={() => {
                    hotelService
                      .eliminarConfig(hotel.id, c.id)
                      .then(() => {
                        // configs is non-null here
                        setConfigs(current =>
                          (current ?? []).filter(x => x.id !== c.id)
                        );
                      });
                  }}
                  className="text-red-500 hover:text-red-600"
                >
                  Eliminar
                </button>
              </Card>
            ))
          )}
        </div>
      </div>
    </div>
  );
}
