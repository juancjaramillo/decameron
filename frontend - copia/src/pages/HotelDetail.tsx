import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { getHotel, listConfigs, deleteConfig, Config } from '../api/hotelService';
import { Card, Container, Spinner, Table, Button, Alert } from 'react-bootstrap';
import HotelConfigForm from '../components/HotelConfigForm';

interface Hotel {
  id: number;
  nombre: string;
  direccion: string;
  ciudad: string;
  nit: string;
  max_habitaciones: number;
}

export default function HotelDetail() {
  const { hotelId } = useParams<{ hotelId: string }>();
  const [hotel, setHotel]       = useState<Hotel|null>(null);
  const [configs, setConfigs]   = useState<Config[]>([]);
  const [loading, setLoading]   = useState(true);
  const [error, setError]       = useState<string|null>(null);

  useEffect(() => {
    if (!hotelId) return;
    setLoading(true);
    Promise.all([
      getHotel(+hotelId).then(r => setHotel(r.data)),
      listConfigs(+hotelId).then(r => setConfigs(r.data)),
    ])
      .catch(err => {
        console.error(err);
        setError('Error al cargar datos');
      })
      .finally(() => setLoading(false));
  }, [hotelId]);

  const removeConfig = (id: number) => {
    deleteConfig(id).then(() => {
      setConfigs(configs.filter(c => c.id !== id));
    });
  };

  if (loading) {
    return (
      <Container className="text-center py-5">
        <Spinner animation="border" />
      </Container>
    );
  }

  if (error || !hotel) {
    return (
      <Container className="py-5">
        <Alert variant="danger">{error || 'Hotel no encontrado'}</Alert>
      </Container>
    );
  }

  return (
    <Container className="mt-4">
      <Card className="mb-4">
        <Card.Body>
          <Card.Title>{hotel.nombre}</Card.Title>
          <Card.Text>
            <strong>Ciudad:</strong> {hotel.ciudad}<br/>
            <strong>Dirección:</strong> {hotel.direccion}<br/>
            <strong>NIT:</strong> {hotel.nit}
          </Card.Text>
        </Card.Body>
      </Card>

      <Card className="mb-4">
        <Card.Body>
          <Card.Title>Configuraciones de habitación</Card.Title>
          <HotelConfigForm
            hotelId={hotel.id}
            maxHabitaciones={hotel.max_habitaciones}
            onCreate={cfg => setConfigs([...configs, cfg])}
          />

          {configs.length === 0 ? (
            <Alert variant="info" className="mt-3">
              No hay configuraciones aún.
            </Alert>
          ) : (
            <Table striped bordered hover responsive className="mt-3">
              <thead>
                <tr>
                  <th>Tipo</th>
                  <th>Acomodación</th>
                  <th>Cantidad</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>
                {configs.map(c => (
                  <tr key={c.id}>
                    <td>{c.tipo_habitacion}</td>
                    <td>{c.acomodacion}</td>
                    <td>{c.cantidad}</td>
                    <td>
                      <Button size="sm" variant="danger" onClick={() => removeConfig(c.id)}>
                        Borrar
                      </Button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </Table>
          )}
        </Card.Body>
      </Card>
    </Container>
  );
}
