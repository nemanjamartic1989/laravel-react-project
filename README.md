## 🧩 User CRUD Dashboard

User CRUD Dashboard is a full-stack web application built with **Laravel 12** and **React 18**, providing a modern interface and REST API for managing users.
It includes **soft delete**, **token-based authentication (Sanctum)**, and both **backend** and **end-to-end testing** with **PHPUnit** and **Cypress**.

---

## Tech Stack

### Backend (API)
- **Laravel 12 (PHP 8.2+)**
- **Laravel Sanctum** – API token authentication
- **Eloquent ORM**
- **PHPUnit (Feature + Unit tests)**
- **Docker / Docker Compose**

### Frontend
- **React 18 (Vite)**
- **Axios**
- **React Router DOM**

### Testing
- **PHPUnit** for backend testing
- **Cypress** for E2E (end-to-end) frontend testing

---

## Installation & Setup

### Clone the repository
```bash
git clone https://github.com/username/laravel-react-project.git
cd laravel-react-project

## Useful Commands

### Artisan (Laravel)
| Command | Description |
|---------|-------------|
| `php artisan serve` | Start Laravel development server |
| `php artisan migrate` | Run database migrations |
| `php artisan migrate:refresh --seed` | Refresh migrations and reseed database |
| `php artisan db:seed` | Run database seeders |
| `php artisan tinker` | Open Laravel interactive shell |
| `php artisan test` | Run all tests (feature + unit) |

### Frontend / Node
| Command | Description |
|---------|-------------|
| `npm install` | Install frontend dependencies |
| `npm run dev` | Start Vite development server |
| `npm run build` | Build production-ready frontend |

### Testing
| Command | Description |
|---------|-------------|
| `docker compose exec app php artisan test` | Run all PHPUnit tests |
| `docker compose exec app php artisan test --filter=UserTest` | Run a specific test class |
| `npx cypress run` | Run Cypress tests headless |
| `npx cypress open` | Open Cypress test runner GUI |

