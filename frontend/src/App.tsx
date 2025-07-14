import React from 'react';
import { BrowserRouter, Routes, Route, Navigate, Outlet } from 'react-router-dom';
import { Container } from 'react-bootstrap';

import HotelesList from './pages/HotelesList';
import HotelDetail from './pages/HotelDetail';
import CreateHotel from './pages/CreateHotel';
import Login from './pages/Login';
import AppNavbar from './components/AppNavbar';
import { TOKEN_KEY } from './api/client';

function PrivateRoute() {
  return localStorage.getItem(TOKEN_KEY)
    ? <Outlet />
    : <Navigate to="/login" replace />;
}

export default function App() {
  return (
    <BrowserRouter>
      {/* Siempre mostramos la navbar, incluso si está en login */}
      <AppNavbar />

      {/* Centramos todo el contenido */}
      <Container className="py-4">
        <Routes>
          {/* Ruta pública */}
          <Route path="/login" element={<Login />} />

          {/* Rutas privadas */}
          <Route element={<PrivateRoute />}>
            <Route index element={<Navigate to="/hoteles" replace />} />
            <Route path="hoteles" element={<HotelesList />} />
            <Route path="hoteles/crear" element={<CreateHotel />} />
            <Route path="hoteles/:hotelId" element={<HotelDetail />} />
          </Route>

          {/* Cualquier otra, vuelve a login */}
          <Route path="*" element={<Navigate to="/login" replace />} />
        </Routes>
      </Container>
    </BrowserRouter>
  );
}
