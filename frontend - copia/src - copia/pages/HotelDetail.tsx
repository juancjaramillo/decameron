// src/pages/HotelDetail.tsx

import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { getHotel, listConfigs, createConfig, deleteConfig, Hotel, Config } from '../api/hotelService';
import { Card, Table, Button, Spinner, Form, Row, Col, Alert } from 'react-bootstrap';

export default function HotelDetail() {
  const { hotelId } = useParams();
  const nav = useNavigate();
  const [hotel, setHotel] = useState<Hotel | null>(null);
  const [configs, setConfigs] = useState<Config[]>([]);
  const [loading, setLoading] = useState(true);
  const [tipo, setTipo] = useState<'ESTANDAR' | 'JUNIOR' | 'SUITE'>('ESTANDAR');
  const [acom, setAcom] = useState('');
  const [cant, setCant] = useState(1);
  const [error, setError] = useState<string | null>(null);

  // Opciones por tipo
  const opcionesAcomod: Record<string, string[]> = {
    ESTANDAR: ['SENCILLA', 'DOBLE'],
    JUNIOR: ['TRIPLE', 'CUADRUPLE'],
    SUITE: ['SENCILLA', 'DOBLE', 'TRIPLE']
  };

  // Cargar datos
  useEffect(() => {
    setLoading(true);
    Promise.all([
      getHotel(Number(hotelId)).then(res => setHotel(res.data)),
      listConfigs(Number(hotelId)).then(res => setConfigs(res.data))
    ])
    .catch(() => setError('No se pudo cargar el hotel'))
    .finally(() => setLoading(false));
  }, [hotelId]);

  // Agregar configuración
  const submit = (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);
    createConfig(Number(hotelId), { tipo_habitacion: tipo, acomodacion: acom, cantidad: cant })
      .then(res => {
        setConfigs([...configs, res.data]);
        setCant(1);
        setAcom('');
      })
      .catch(err => setError('Error al agregar configuración'));
  };

  // Confirmar y eliminar configuración
  const onDelete = (id: number) => {
    if (window.confirm('¿Desea eliminar la configuración?')) {
      deleteConfig(id).then(() => {
        setConfigs(configs.filter(c => c.id !== id));
      });
    }
  };

  if (loading) return <Spinner animation="border" />;
  if (!hotel) return <Alert variant="danger">Hotel no encontrado</Alert>;

  return (
    <Card className="max-w-lg mx-auto p-4 shadow">
      <Card.Body>
        <Button variant="secondary" onClick={() => nav(-1)} className="mb-3">← Volver</Button>
        <h2 className="mb-3">{hotel.nombre}</h2>
        <div className="mb-3">
          <b>Dirección:</b> {hotel.direccion} <br />
          <b>Ciudad:</b> {hotel.ciudad} <br />
          <b>NIT:</b> {hotel.nit} <br />
          <b>Habitaciones:</b> {hotel.max_habitaciones}
        </div>

        <h4 className="mt-4">Configuraciones de habitaciones</h4>
        {error && <Alert variant="danger">{error}</Alert>}

        <Form onSubmit={submit} className="mb-3">
          <Row className="align-items-end">
            <Col>
              <Form.Label>Tipo</Form.Label>
              <Form.Select value={tipo} onChange={e => {
                setTipo(e.target.value as any);
                setAcom('');
              }}>
                {Object.keys(opcionesAcomod).map(opt => (
                  <option key={opt} value={opt}>{opt}</option>
                ))}
              </Form.Select>
            </Col>
            <Col>
              <Form.Label>Acomodación</Form.Label>
              <Form.Select value={acom} onChange={e => setAcom(e.target.value)} required>
                <option value="">—</option>
                {opcionesAcomod[tipo].map(opt => (
                  <option key={opt} value={opt}>{opt}</option>
                ))}
              </Form.Select>
            </Col>
            <Col>
              <Form.Label>Cantidad</Form.Label>
              <Form.Control type="number" min={1} max={hotel.max_habitaciones} value={cant}
                onChange={e => setCant(Number(e.target.value))} required />
            </Col>
            <Col xs="auto">
              <Button type="submit" variant="primary">Agregar</Button>
            </Col>
          </Row>
        </Form>

        <Table striped bordered hover size="sm" responsive>
          <thead>
            <tr>
              <th>Tipo</th>
              <th>Acomodación</th>
              <th>Cantidad</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            {configs.map(cfg => (
              <tr key={cfg.id}>
                <td>{cfg.tipo_habitacion}</td>
                <td>{cfg.acomodacion}</td>
                <td>{cfg.cantidad}</td>
                <td>
                  <Button size="sm" variant="danger" onClick={() => onDelete(cfg.id)}>
                    Borrar
                  </Button>
                </td>
              </tr>
            ))}
          </tbody>
        </Table>
      </Card.Body>
    </Card>
  );
}
