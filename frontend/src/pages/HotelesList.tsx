import React, { useEffect, useState } from 'react';
import { Table, Button, Spinner } from 'react-bootstrap';
import { listHoteles, deleteHotel, Hotel } from '../api/hotelService';
import { useNavigate } from 'react-router-dom';

export default function HotelesList() {
  const [hoteles, setHoteles] = useState<Hotel[]>([]);
  const [loading, setLoading] = useState(true);
  const nav = useNavigate();

  useEffect(() => {
    listHoteles()
      .then(res => setHoteles(res.data))
      .finally(() => setLoading(false));
  }, []);

  const onDelete = (id: number) => {
    deleteHotel(id).then(() => {
      setHoteles(hoteles.filter(h => h.id !== id));
    });
  };

  if (loading) return <Spinner animation="border" />;

  return (
    <>
      <div className="d-flex justify-content-between align-items-center mb-3">
        <h1>Hoteles</h1>
        <Button onClick={() => nav('/hoteles/crear')}>Crear Hotel</Button>
      </div>
      <Table striped bordered hover responsive>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Ciudad</th>
            <th># Habitaciones</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {hoteles.map(h => (
            <tr key={h.id}>
              <td>{h.nombre}</td>
              <td>{h.ciudad}</td>
              <td>{h.max_habitaciones}</td>
              <td>
                <Button size="sm" onClick={() => nav(`/hoteles/${h.id}`)} className="me-2">
                  Ver
                </Button>
                <Button size="sm" variant="danger" onClick={() => onDelete(h.id)}>
                  Borrar
                </Button>
              </td>
            </tr>
          ))}
        </tbody>
      </Table>
    </>
  );
}
