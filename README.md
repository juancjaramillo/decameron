# Decameron

[![CI Backend](https://github.com/juancjaramillo/decameron/actions/workflows/backend.yml/badge.svg)](https://github.com/juancjaramillo/decameron/actions/workflows/backend.yml) [![CI Frontend](https://github.com/juancjaramillo/decameron/actions/workflows/frontend.yml/badge.svg)](https://github.com/juancjaramillo/decameron/actions/workflows/frontend.yml)
[![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/juancjaramillo/decameron/releases) [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

**Decameron** es una aplicación completa para gestionar hoteles, habitaciones y sus configuraciones. Consta de:

* **Backend**: API REST en **Laravel 12** + **Sanctum** (tokens), base de datos **PostgreSQL**.
* **Frontend**: SPA en **React 18** + **React-Bootstrap** y **Tailwind CSS**.

---

## 📖 Descripción

Decameron permite:

* Autenticación segura con tokens (Laravel Sanctum).
* Crear, listar, editar y eliminar hoteles y configuraciones de habitaciones.
* Manejar roles y permisos (opcional).
* Interfaz reactiva y responsiva adaptada a dispositivos móviles y de escritorio.

---

## 🏗️ Arquitectura

```
decameron/
├── backend/        # Laravel 12 + Sanctum + PostgreSQL
│   ├── app/
│   ├── routes/
│   ├── database/
│   └── ...
├── frontend/       # React 18 + React-Bootstrap + Tailwind
│   ├── src/
│   ├── public/
│   └── ...
└── docs/           # Documentación, capturas y diagramas
    └── images/
        ├── hoteles-list.png
        └── crear-hotel.png
    └── postman/
        ├── Decameron_auth_postman.json    # Para facilitar pruebas de la API, 
    └── diagramas/
        ├── diagram_uml.png
        └── crear-hotel.png
```

---

## 📋 Índice

1. [Pre requisitos](#-pre-requisitos)
2. [Instalación](#-instalación)
3. [Configuración](#-configuración)

   * [.env Backend](#env-backend)
   * [.env Frontend](#env-frontend)
4. [Migraciones y seeders](#-migraciones-y-seeders)
5. [Ejecución](#-ejecución)

   * [Backend](#backend)
   * [Frontend](#frontend)
6. [Endpoints API](#-endpoints-api)
7. [Pruebas](#-pruebas)
8. [Integración continua (CI)](#-integración-continua-ci)
9. [Estructura de directorios](#-estructura-de-directorios)
10. [Capturas de pantalla](#-capturas-de-pantalla)
11. [Tecnologías](#-tecnologías)
12. [Contribuciones](#-contribuciones)
13. [Licencia](#-licencia)

---

## 🎯 Pre requisitos

* **PHP 8.2+** y **Composer**
* **Node.js 16+** y **npm**
* **Git**
* **XAMPP** (o similar con Apache)
* **PostgreSQL** y **pgAdmin**

Antes de comenzar, asegúrate de:

1. Tener **PostgreSQL** instalado y un usuario configurado.
2. Crear la base de datos `decameron` en pgAdmin o consola.

---

## 🚀 Instalación

Clona el repositorio y prepara el entorno:

```bash
cd C:/xampp/htdocs
git clone https://github.com/juancjaramillo/decameron.git
cd decameron
```

### Backend

```bash
cd backend
composer install           # Instala dependencias PHP
copy .env.example .env     # Copia archivo de entorno
php artisan key:generate   # Genera APP_KEY
```

### Frontend

```bash
cd frontend
npm ci                     # Instala dependencias JS
```

---

## 🔧 Configuración

### .env Backend

Edita `backend/.env` con tus datos de PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=decameron
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

### .env Frontend

Crea `frontend/.env` (añade en raíz de frontend):

```env
REACT_APP_API_URL=http://localhost:8000/api/v1
```

Guarda y cierra ambos archivos.

---

## 🛠️ Migraciones y seeders

```bash
# En carpeta backend/
php artisan migrate       # Crea tablas
php artisan db:seed        # Poblado inicial (opcional)
```

---

## ▶️ Ejecución

### Backend

```bash
cd backend
php artisan serve         # http://localhost:8000
```

### Frontend

```bash
cd frontend
npm start                 # http://localhost:3000
```

¡Listo! Ambas aplicaciones corriendo en paralelo.

---

## 🔗 Endpoints API

| Método | Ruta                                   | Descripción                  |
| ------ | -------------------------------------- | ---------------------------- |
| POST   | `/api/v1/auth/token`                   | Login y obtener Bearer token |
| GET    | `/api/v1/hoteles`                      | Listar hoteles               |
| POST   | `/api/v1/hoteles`                      | Crear hotel                  |
| GET    | `/api/v1/hoteles/{id}`                 | Detallar hotel               |
| DELETE | `/api/v1/hoteles/{id}`                 | Eliminar hotel               |
| GET    | `/api/v1/hoteles/{id}/configuraciones` | Listar configuraciones       |
| POST   | `/api/v1/hoteles/{id}/configuraciones` | Crear configuración          |
| DELETE | `/api/v1/configuraciones/{id}`         | Eliminar configuración       |

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

![Configurar hotel](docs/images/configurar-hotel.png)
*Formulario para configurar el nuevo hotel y con validaciones.*

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



## 📷 Documentación Swagger

La documentación interactiva de la API está disponible en **Swagger UI**:

```
http://localhost:8000/api/documentation
```

Asegúrate de haber publicado los assets de Swagger con:

```bash
php artisan l5-swagger:generate
```

---

## 🔗 Endpoints API

| Método | Ruta                                   | Descripción                  |
| ------ | -------------------------------------- | ---------------------------- |
| POST   | `/api/v1/auth/token`                   | Login y obtener Bearer token |
| GET    | `/api/v1/hoteles`                      | Listar hoteles               |
| POST   | `/api/v1/hoteles`                      | Crear hotel                  |
| GET    | `/api/v1/hoteles/{id}`                 | Detallar hotel               |
| DELETE | `/api/v1/hoteles/{id}`                 | Eliminar hotel               |
| GET    | `/api/v1/hoteles/{id}/configuraciones` | Listar configuraciones       |
| POST   | `/api/v1/hoteles/{id}/configuraciones` | Crear configuración          |
| DELETE | `/api/v1/configuraciones/{id}`         | Eliminar configuración       |



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


## 📬 Colección Postman

Para facilitar pruebas de la API, incluye la colección de Postman `docs/postman/Decameron.postman_collection.json`.

1. Abre Postman y elige **Import**.
2. Selecciona el archivo `Decameron.postman_collection.json`.
3. La colección tendrá los endpoints principales listos para probar.


---

## 📷 Documentación

![Diagrama UML de la Arquitectura del Módulo de Hoteles y Configuración de Habitaciones](docs/diagramas/diagram_uml.png)
Este diagrama ilustra la estructura de clases e interfaces que componen el backend de Decameron para la gestión de hoteles y sus configuraciones de habitación. En él puedes ver:

* **Entidades de Dominio**: `Hotel` y `HotelRoomConfig` con sus atributos principales (ID, nombre, ubicación, tipo de habitación, cantidad, etc.).
* **Controladores**: `HotelController` y `HotelRoomConfigController`, que definen los endpoints (`index`, `show`, `store`, `update`, `destroy`) para cada recurso.
* **Interfaces de Servicio**: `HotelServiceInterface` y `HotelRoomConfigServiceInterface`, que declaran las operaciones de negocio (listado, creación, actualización, eliminación).
* **Implementaciones de Servicio**: `HotelService` y `HotelRoomConfigService` que implementan la lógica de negocio delegando en los repositorios.
* **Interfaces de Repositorio**: `HotelRepositoryInterface` y `HotelRoomConfigRepositoryInterface`, que especifican los métodos de acceso a datos.
* **Implementaciones de Repositorio**: `HotelRepository` y `HotelRoomConfigRepository`, que interactúan directamente con la base de datos (PostgreSQL) para ejecutar consultas.
* **Relaciones y Dependencias**: Controladores dependen de Servicios, Servicios dependen de Repositorios e inyección de dependencias para bajo acoplamiento y pruebas.

Este diseño sigue el patrón **Controller → Service → Repository**, promoviendo separación de responsabilidades, testabilidad y escalabilidad.

![Clase Hotel](docs/diagramas/uml-class-hotel.png)
*Diagrama de clases principales (Hotel, Configuración, Usuario).*

![Secuencia para crear hotel](docs/diagramas/uml-sequence-create-hotel.png)
* Secuencia de creación de un hotel.*

![Despliegue de arquitectura](docs/diagramas/uml-despliegue.png)
*Despliegue de arquitectura (Laravel + React + PostgreSQL).*




## 📄 Licencia

Este proyecto está bajo la **Licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más detalles.

---

*¡Gracias por usar Decameron! *
