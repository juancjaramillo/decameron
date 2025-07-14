import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import { HotelesList } from './pages/HotelesList';
import { HotelDetail } from './pages/HotelDetail';

export default function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Navigate to="/hoteles" />} />
        <Route path="/hoteles" element={<HotelesList />} />
        <Route path="/hoteles/:id" element={<HotelDetail />} />
      </Routes>
    </BrowserRouter>
  );
}
