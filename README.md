# Laravel Blog

This project is a blog developed using the Laravel framework, with Docker support and a bot system for activity simulation.

## Getting Started

Follow the instructions below to deploy the project locally.

### Prerequisites

- Docker and Docker Compose
- Git

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/GetLivreru/Blog.git
   ```

2. **Navigate to the project directory:**
   ```bash
   cd Blog
   ```

3. **Create environment configuration file:**
   ```bash
   cp .env.example .env
   ```

4. **Start Docker containers:**
   ```bash
   docker-compose up -d
   ```

5. **Install PHP dependencies:**
   ```bash
   docker exec -it laravel_app composer install
   ```

6. **Generate application key:**
   ```bash
   docker exec -it laravel_app php artisan key:generate
   ```

7. **Run database migrations:**
   ```bash
   docker exec -it laravel_app php artisan migrate
   ```

8. **Install Node.js dependencies and build frontend:**
   ```bash
   docker exec -it laravel_app npm install
   docker exec -it laravel_app npm run dev
   ```

The application will now be available at `http://localhost:8000`.

## Bot Management

The project includes a bot system for simulating user activity. The following commands are available:

- **Create bots:**
  ```bash
  docker exec -it laravel_app php artisan bots:manage create
  ```

- **Start bots:**
  ```bash
  docker exec -it laravel_app php artisan bots:manage start
  ```

- **Stop bots:**
  ```bash
  docker exec -it laravel_app php artisan bots:manage stop
  ```

- **View bot status:**
  ```bash
  docker exec -it laravel_app php artisan bots:manage status
  ```

## Monitoring

The project includes a monitoring system based on Prometheus and Grafana:

- **Prometheus** is available at: `http://localhost:9090`
- **Grafana** is available at: `http://localhost:3000`

## Project Structure

- `app/` — contains the main application code
  - `Models/` — data models
  - `Services/` — services, including BotService
  - `Console/Commands/` — bot management commands
- `bootstrap/` — framework initialization
- `config/` — configuration files
- `database/` — database migrations and seeders
- `docker/` — Docker configuration
- `public/` — publicly accessible files and application entry point
- `resources/` — views and resources (CSS, JS)
- `routes/` — route files
- `storage/` — compiled templates, sessions, cache, and files
- `tests/` — tests

## Technologies

- Laravel 8.x
- Docker
- Redis (for queues and cache)
- Nginx
- Prometheus
- Grafana
- SQLite (for development)

## License

MIT


