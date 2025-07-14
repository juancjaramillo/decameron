import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { createHotel } from '../api/hotelService';
import { Container, Card, Form, Button, Alert, Spinner } from 'react-bootstrap';

export default function CreateHotel() {
  const nav = useNavigate();
  const [nombre, setNombre]               = useState('');
  const [direccion, setDireccion]         = useState('');
  const [ciudad, setCiudad]               = useState('');
  const [nit, setNit]                     = useState('');
  const [maxHabitaciones, setMaxHabitaciones] = useState(1);
  const [error, setError]                 = useState<string|null>(null);
  const [submitting, setSubmitting]       = useState(false);

  const submit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);
    setSubmitting(true);
    try {
      await createHotel({ nombre, direccion, ciudad, nit, max_habitaciones: maxHabitaciones });
      nav('/hoteles');
    } catch (err: any) {
      console.error(err);
      setError(err.response?.data?.message || 'Error al crear hotel');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <Container className="mt-4">
      <Card className="mx-auto" style={{ maxWidth: '600px' }}>
        <Card.Body>
          <Card.Title>Crear Hotel</Card.Title>

          {error && <Alert variant="danger">{error}</Alert>}

          <Form onSubmit={submit}>
            <Form.Group className="mb-3" controlId="formNombre">
              <Form.Label>Nombre</Form.Label>
              <Form.Control
                type="text"
                placeholder="Nombre del hotel"
                value={nombre}
                onChange={e => setNombre(e.target.value)}
                required
              />
            </Form.Group>

            <Form.Group className="mb-3" controlId="formDireccion">
              <Form.Label>Dirección</Form.Label>
              <Form.Control
                type="text"
                placeholder="Dirección"
                value={direccion}
                onChange={e => setDireccion(e.target.value)}
                required
              />
            </Form.Group>

            <Form.Group className="mb-3" controlId="formCiudad">
              <Form.Label>Ciudad</Form.Label>
              <Form.Control
                type="text"
                placeholder="Ciudad"
                value={ciudad}
                onChange={e => setCiudad(e.target.value)}
                required
              />
            </Form.Group>

            <Form.Group className="mb-3" controlId="formNit">
              <Form.Label>NIT</Form.Label>
              <Form.Control
                type="text"
                placeholder="NIT"
                value={nit}
                onChange={e => setNit(e.target.value)}
                required
              />
            </Form.Group>

            <Form.Group className="mb-3" controlId="formMaxHabitaciones">
              <Form.Label>Máx. Habitaciones</Form.Label>
              <Form.Control
                type="number"
                min={1}
                value={maxHabitaciones}
                onChange={e => setMaxHabitaciones(Number(e.target.value))}
                required
              />
            </Form.Group>

            <div className="d-flex justify-content-between">
              <Button variant="secondary" onClick={() => nav(-1)}>
                Cancelar
              </Button>
              <Button variant="primary" type="submit" disabled={submitting}>
                {submitting ? <Spinner as="span" animation="border" size="sm" /> : 'Crear'}
              </Button>
            </div>
          </Form>
        </Card.Body>
      </Card>
    </Container>
  );
}
