import React from 'react';
import { Navbar, Nav, Container, Button } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import { TOKEN_KEY } from '../api/client';
import logo from '../assets/decameron-logo.png';

export default function AppNavbar() {
  const nav = useNavigate();

  function handleLogout() {
    localStorage.removeItem(TOKEN_KEY);
    nav('/login', { replace: true });
  }

  return (
    <Navbar bg="light" expand="lg" className="mb-4 shadow-sm">
      <Container>
        <Navbar.Brand onClick={() => nav('/hoteles')} style={{ cursor: 'pointer' }}>
         <img src={logo} alt="Decameron" style={{ height: '30px', marginRight: '8px' }}/>
          Decameron
        </Navbar.Brand>
        <Navbar.Toggle aria-controls="main-nav" />
        <Navbar.Collapse id="main-nav">
          <Nav className="me-auto">
            <Nav.Link onClick={() => nav('/hoteles')}>Hoteles</Nav.Link>
            <Nav.Link onClick={() => nav('/hoteles/crear')}>Crear Hotel</Nav.Link>
          </Nav>
          <Button variant="outline-danger" onClick={handleLogout}>
            Logout
          </Button>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}
