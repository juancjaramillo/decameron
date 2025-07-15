// src/App.tsx
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
  const token = localStorage.getItem(TOKEN_KEY);
  return token ? <Outlet /> : <Navigate to="/login" replace />;
}

export default function App() {
  return (
    <BrowserRouter>
      {/* Navbar siempre visible */}
      <AppNavbar />

      <Container className="py-4">
        <Routes>
          {/* Ruta pública */}
          <Route path="/login" element={<Login />} />

          {/* Rutas protegidas */}
          <Route element={<PrivateRoute />}>
            <Route index element={<Navigate to="/hoteles" replace />} />
            <Route path="hoteles" element={<HotelesList />} />
            <Route path="hoteles/crear" element={<CreateHotel />} />
            <Route path="hoteles/:hotelId" element={<HotelDetail />} />
          </Route>

          {/* Cualquier otra ruta */}
          <Route
            path="*"
            element={<Navigate to={localStorage.getItem(TOKEN_KEY) ? '/hoteles' : '/login'} replace />}
          />
        </Routes>
      </Container>
    </BrowserRouter>
  );
}
