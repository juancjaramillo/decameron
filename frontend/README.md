# Decameron

[![CI Backend](https://github.com/juancjaramillo/decameron/actions/workflows/backend.yml/badge.svg)](https://github.com/juancjaramillo/decameron/actions/workflows/backend.yml) [![CI Frontend](https://github.com/juancjaramillo/decameron/actions/workflows/frontend.yml/badge.svg)](https://github.com/juancjaramillo/decameron/actions/workflows/frontend.yml)
[![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/juancjaramillo/decameron/releases) [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

**Decameron** es una aplicación completa para gestionar hoteles, habitaciones y sus configuraciones. Consta de:

* **Backend**: API REST en **Laravel 12** + **Sanctum** (tokens), base de datos **PostgreSQL**.
* **Frontend**: SPA en **React 18** + **React-Bootstrap** y **Tailwind CSS**.

---

### Diagrama UML de la Arquitectura del Módulo de Hoteles y Configuración de Habitaciones

**Descripción:**

Este diagrama ilustra la estructura de clases e interfaces que componen el backend de Decameron para la gestión de hoteles y sus configuraciones de habitación. En él puedes ver:

* **Entidades de Dominio**: `Hotel` y `HotelRoomConfig` con sus atributos principales (ID, nombre, ubicación, tipo de habitación, cantidad, etc.).
* **Controladores**: `HotelController` y `HotelRoomConfigController`, que definen los endpoints (`index`, `show`, `store`, `update`, `destroy`) para cada recurso.
* **Interfaces de Servicio**: `HotelServiceInterface` y `HotelRoomConfigServiceInterface`, que declaran las operaciones de negocio (listado, creación, actualización, eliminación).
* **Implementaciones de Servicio**: `HotelService` y `HotelRoomConfigService` que implementan la lógica de negocio delegando en los repositorios.
* **Interfaces de Repositorio**: `HotelRepositoryInterface` y `HotelRoomConfigRepositoryInterface`, que especifican los métodos de acceso a datos.
* **Implementaciones de Repositorio**: `HotelRepository` y `HotelRoomConfigRepository`, que interactúan directamente con la base de datos (PostgreSQL) para ejecutar consultas.
* **Relaciones y Dependencias**: Controladores dependen de Servicios, Servicios dependen de Repositorios e inyección de dependencias para bajo acoplamiento y pruebas.

Este diseño sigue el patrón **Controller → Service → Repository**, promoviendo separación de responsabilidades, testabilidad y escalabilidad.

## 📷 Documentación Swagger

La documentación interactiva de la API está disponible en **Swagger UI**:

```
http://localhost:8000/api/documentation
```

Asegúrate de haber publicado los assets de Swagger con:

```bash
php artisan l5-swagger:generate
```

\------ | ---------------------------------------- | ----------------------------- |
\| POST   | `/api/v1/auth/token`                     | Login y obtener Bearer token  |
\| GET    | `/api/v1/hoteles`                        | Listar hoteles                |
\| POST   | `/api/v1/hoteles`                        | Crear hotel                   |
\| GET    | `/api/v1/hoteles/{id}`                   | Detallar hotel                |
\| DELETE | `/api/v1/hoteles/{id}`                   | Eliminar hotel                |
\| GET    | `/api/v1/hoteles/{id}/configuraciones`   | Listar configuraciones        |
\| POST   | `/api/v1/hoteles/{id}/configuraciones`   | Crear configuración           |
\| DELETE | `/api/v1/configuraciones/{id}`           | Eliminar configuración        |

---

## 🧪 Pruebas

### Backend

```bash
cd backend
php artisan test          # Pest/PHPUnit
```

### Frontend

```bash
cd frontend
npm test                  # Jest + React Testing Library
```

---

## ⚙️ Integración continua (CI)

Badges al inicio enlazan a tus workflows de GitHub Actions:

* **backend.yml**: tests, migraciones y lint PHP.
* **frontend.yml**: tests y build de React.

```yaml
# Ejemplo simplified backend.yml
on: [push]
jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with: { php-version: '8.2' }
      - run: composer install
      - run: php artisan migrate --env=testing --force
      - run: php artisan test
```

---

## 📁 Estructura de directorios

```
decameron/
├── backend/
│   ├── app/
│   ├── config/
│   ├── database/
│   └── routes/
├── frontend/
│   ├── public/
│   └── src/
├── docs/
│   └── images/
└── README.md
```

---

## 📷 Capturas de pantalla

![Listado de hoteles](docs/images/hoteles-list.png)
*Listado de todos los hoteles existentes.*

![Crear hotel](docs/images/crear-hotel.png)
*Formulario para agregar un nuevo hotel.*

---

## 🛠️ Tecnologías utilizadas

* **PHP 8.2** / **Laravel 12**
* **Node.js 16+** / **React 18**
* **Sanctum** para autenticación por tokens
* **PostgreSQL**
* **React-Bootstrap** + **Tailwind CSS**
* **Axios** para consumo de API
* **GitHub Actions** para CI

---

## 🧪 Pruebas Unitarias

### Backend (Pest/PHPUnit)

En la carpeta `backend/`, ejecuta:

```bash
composer require pestphp/pest --dev
php artisan pest:install
php artisan test
```

Esto correrá tus pruebas unitarias y de feature definidas en `tests/`.

### Frontend (Jest + React Testing Library)

En la carpeta `frontend/`, instala dependencias de test:

```bash
npm install --save-dev jest @testing-library/react @testing-library/jest-dom
```

Luego ejecuta:

```bash
npm test
```

Ejecutarás las pruebas ubicadas en `src/__tests__/`.

---

## 📬 Colección Postman

Para facilitar pruebas de la API, incluye la colección de Postman `docs/postman/Decameron.postman_collection.json`.

1. Abre Postman y elige **Import**.
2. Selecciona el archivo `Decameron.postman_collection.json`.
3. La colección tendrá los endpoints principales listos para probar.

---

## 🤝 Contribuciones

1. Haz un **fork** del repositorio.
2. Crea una **branch** (`git checkout -b feature/nombre`).
3. Realiza tus cambios y haz **commit** (`git commit -m 'Agrega nueva funcionalidad'`).
4. Sube a tu fork (`git push origin feature/nombre`).
5. Abre un **Pull Request**.

---

## 📄 Licencia

Este proyecto está bajo la **Licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más detalles.

---

*¡Gracias por usar Decameron! Cualquier duda, abre un issue o contacta al mantenedor.*
