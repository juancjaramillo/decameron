// frontend/src/components/Navbar.tsx
import React from 'react';
import { Link } from 'react-router-dom';

export function Navbar() {
  return (
    <nav className="bg-white shadow">
      <div className="container mx-auto p-4 flex justify-between items-center">
        <Link to="/" className="text-xl font-bold">Decameron</Link>
        <div className="space-x-4">
          <Link to="/hoteles" className="hover:underline">Hoteles</Link>
        </div>
      </div>
    </nav>
  );
}
