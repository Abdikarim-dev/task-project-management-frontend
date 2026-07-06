# Taskify — Frontend

Laravel 12 Blade frontend for the Task & Project Management System. Consumes the REST API in the `server` folder.

> **UI screenshots** are stored in [`docs/screenshots/`](docs/screenshots/).  
> For a full per-screen breakdown see [`docs/SCREENSHOTS.md`](docs/SCREENSHOTS.md).

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
| Admin | admin@example.com (Hassan Abdi) | password |
| Staff | amina@example.com (Amina Mohamed) | password |

## Architecture

The frontend acts as a **session-based BFF** (Backend for Frontend):

- Web routes and Blade views for the UI
- `ApiClient` service communicates with the backend API
- Sanctum token stored in session after login
- Role-based navigation (Admin vs Staff)

```
Browser → Web Routes → Controllers → ApiClient → Backend API
```

## UI Screenshots

The app ships with **15 reference screenshots** under [`docs/screenshots/`](docs/screenshots/). Full per-screen documentation (routes, roles, layout, sample data, interactions) is in [`docs/SCREENSHOTS.md`](docs/SCREENSHOTS.md).

### Quick reference

| Area | Screenshots | Who can access |
|------|-------------|----------------|
| [Dashboard](docs/SCREENSHOTS.md#dashboard) | Admin light/dark, Staff | All users |
| [Projects](docs/SCREENSHOTS.md#projects-admin-only) | List, Create, View | Admin |
| [Tasks](docs/SCREENSHOTS.md#tasks) | List, Create, Edit, View | Admin (all tasks) · Staff (My Tasks) |
| [Users](docs/SCREENSHOTS.md#users-admin-only) | Grid, Individual profile | Admin |
| [Profile](docs/SCREENSHOTS.md#profile-signed-in-user) | — (live page only) | All users |

### Highlights visible in screenshots

- **Somali-themed demo data** — Mogadishu Port, Salaam Somali Bank, Dahabshiil, Berbera Corridor, Zoobe Shop, etc.
- **Role-based navigation** — admins see Projects/Tasks/Users; staff see My Tasks only
- **Light & dark themes** — user preference (sun/moon toggle in top bar), not system theme
- **Project team → task assignees** — create-project team checkboxes restrict who appears in task assignee dropdowns
- **Conditional project delete** — only projects with zero tasks (e.g. Zoobe Shop)
- **User management** — create users, suspend staff, view per-user stats/charts/projects table

### Sample screens

| Dashboard (admin, light) | My Tasks (staff, dark) | User profile (admin view) |
|--------------------------|------------------------|---------------------------|
| ![Dashboard](docs/screenshots/dashboard/admin/dashboard-light-mode.png) | ![My Tasks](docs/screenshots/tasks/staff/view-tasks.png) | ![User profile](docs/screenshots/users/each-user-data-preview-admin.png) |
