import React, { useState } from 'react';
import { Container, Row, Col, Card, Form, Button, Alert, InputGroup } from 'react-bootstrap';
import { loginAPI } from '../api/authService';
import { useNavigate } from 'react-router-dom';
import { TOKEN_KEY } from '../api/client';

export default function Login() {
  const [email, setEmail]       = useState('prueba@prueba.com');
  const [password, setPassword] = useState('prueba123');
  const [error, setError]       = useState<string|null>(null);
  const nav = useNavigate();

  const submit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);
    try {
      const res = await loginAPI(email, password);
      localStorage.setItem(TOKEN_KEY, res.data.token);
      nav('/hoteles', { replace: true });
    } catch (err: any) {
      setError(err.response?.data?.message || 'Credenciales inválidas');
    }
  };

  return (
    <Container fluid className="vh-100 d-flex align-items-center justify-content-center bg-light">
      <Row className="w-100">
        <Col xs={12} md={6} lg={4} className="mx-auto">
          <Card className="shadow">
            <Card.Body>
              <Card.Title className="text-center mb-4">Iniciar Sesión</Card.Title>

              {error && <Alert variant="danger">{error}</Alert>}

              <Form onSubmit={submit}>
                <Form.Group controlId="loginEmail" className="mb-3">
                  <Form.Label>Email</Form.Label>
                  <InputGroup>
                    <InputGroup.Text>📧</InputGroup.Text>
                    <Form.Control
                      type="email"
                      placeholder="tu@correo.com"
                      value={email}
                      onChange={e => setEmail(e.target.value)}
                      required
                    />
                  </InputGroup>
                </Form.Group>

                <Form.Group controlId="loginPassword" className="mb-4">
                  <Form.Label>Contraseña</Form.Label>
                  <InputGroup>
                    <InputGroup.Text>🔒</InputGroup.Text>
                    <Form.Control
                      type="password"
                      placeholder="••••••••"
                      value={password}
                      onChange={e => setPassword(e.target.value)}
                      required
                    />
                  </InputGroup>
                </Form.Group>

                <div className="d-grid">
                  <Button variant="primary" type="submit">
                    Entrar
                  </Button>
                </div>
              </Form>
            </Card.Body>

            
          </Card>
        </Col>
      </Row>
    </Container>
  );
}
