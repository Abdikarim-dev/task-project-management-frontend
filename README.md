# Taskify — Frontend

Laravel 12 Blade frontend for the Task & Project Management System. Consumes the REST API in the `server` folder.

## Stack

- Laravel 12
- Blade Templates
- Tailwind CSS 4
- Alpine.js
- Chart.js
- Laravel Vite

## Requirements

- PHP 8.2+
- Node.js 18+
- Backend API running (see `../server/README.md`)

## Setup

```bash
cd client
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
```

Configure the API URL in `.env`:

```env
APP_URL=http://localhost:8001
API_BASE_URL=http://localhost:8000/api
```

Start the frontend (port 8001):

```bash
php artisan serve --port=8001
```

For development with hot reload:

```bash
composer dev
```

## Demo Accounts

| Role  | Email               | Password |
|-------|---------------------|----------|
| Admin | admin@example.com   | password |
| Staff | sarah@example.com   | password |

## Architecture

The frontend acts as a **session-based BFF** (Backend for Frontend):

- Web routes and Blade views for the UI
- `ApiClient` service communicates with the backend API
- Sanctum token stored in session after login
- Role-based navigation (Admin vs Staff)

```
Browser → Web Routes → Controllers → ApiClient → Backend API
```
