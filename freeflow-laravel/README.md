# 🌊 FreeFlow - Laravel Backend

**FreeFlow** is an all-in-one platform built for freelancers to **showcase their work, manage clients, track time, and get paid**—all from one clean, beautiful API.

This is the Laravel backend implementation of the FreeFlow platform, providing a robust REST API with modern PHP practices.

## ✨ Features

- 🔐 **Authentication & Authorization** – JWT-based auth with social login support
- 👥 **User Management** – Complete user profiles with email verification
- 🎨 **Project Management** – Create, manage, and showcase projects
- 👔 **Client Management** – Track client information and relationships
- ⏱️ **Time Tracking** – Log billable and non-billable hours
- 💸 **Invoice Management** – Generate and track professional invoices
- 📊 **Dashboard Analytics** – Comprehensive business insights
- 🔒 **Security** – Rate limiting, CORS, input validation, and more

## 🛠️ Tech Stack

| Component | Technology |
|-----------|------------|
| Framework | [Laravel 11](https://laravel.com/) |
| Database | MySQL/PostgreSQL |
| Authentication | [Laravel Sanctum](https://laravel.com/docs/sanctum) |
| Authorization | [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) |
| Image Processing | [Intervention Image](http://image.intervention.io/) |
| Social Auth | [Laravel Socialite](https://laravel.com/docs/socialite) |
| Queue System | [Laravel Horizon](https://laravel.com/docs/horizon) |
| API Resources | [Laravel API Resources](https://laravel.com/docs/eloquent-resources) |
| Validation | [Form Requests](https://laravel.com/docs/validation#form-request-validation) |

## 🚀 Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL/PostgreSQL
- Node.js & NPM (for asset compilation)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/freeflow-laravel.git
   cd freeflow-laravel
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure your environment**
   Edit `.env` file with your database and other service credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=freeflow
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   # Social Login
   GITHUB_CLIENT_ID=your_github_client_id
   GITHUB_CLIENT_SECRET=your_github_client_secret
   GOOGLE_CLIENT_ID=your_google_client_id
   GOOGLE_CLIENT_SECRET=your_google_client_secret
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Storage setup**
   ```bash
   php artisan storage:link
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## 📚 API Documentation

### Authentication Endpoints

```
POST /api/auth/register          - Register new user
POST /api/auth/login             - Login user
POST /api/auth/logout            - Logout user
GET  /api/auth/me                - Get authenticated user
POST /api/auth/refresh           - Refresh token
GET  /api/auth/verify-email      - Verify email address
POST /api/auth/forgot-password   - Send password reset link
POST /api/auth/reset-password    - Reset password

# Social Authentication
GET  /api/auth/{provider}/redirect  - Redirect to social provider
GET  /api/auth/{provider}/callback  - Handle social callback
```

### Core Endpoints

```
# Dashboard
GET  /api/dashboard                    - Get dashboard stats
GET  /api/dashboard/recent-activities  - Get recent activities
GET  /api/dashboard/earnings-chart     - Get earnings chart data

# Projects
GET    /api/projects           - List projects
POST   /api/projects           - Create project
GET    /api/projects/{id}      - Get project
PUT    /api/projects/{id}      - Update project
DELETE /api/projects/{id}      - Delete project
POST   /api/projects/{id}/images - Upload project images

# Portfolio (Public)
GET  /api/portfolio?username={username} - Get public portfolio
```

### Request/Response Examples

**Register User:**
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "John",
    "last_name": "Doe",
    "username": "johndoe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "terms": true
  }'
```

**Create Project:**
```bash
curl -X POST http://localhost:8000/api/projects \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "E-commerce Website",
    "description": "Modern e-commerce platform",
    "status": "active",
    "budget": 5000.00,
    "hourly_rate": 75.00,
    "tags": ["web", "ecommerce", "react"]
  }'
```

## 🏗️ Architecture

### Directory Structure

```
app/
├── Http/
│   ├── Controllers/          # API Controllers
│   ├── Requests/            # Form Request Validation
│   ├── Resources/           # API Resources
│   └── Middleware/          # Custom Middleware
├── Models/                  # Eloquent Models
├── Services/               # Business Logic Services
├── Policies/               # Authorization Policies
└── Notifications/          # Email Notifications

database/
├── migrations/             # Database Migrations
├── seeders/               # Database Seeders
└── factories/             # Model Factories

routes/
├── api.php                # API Routes
└── web.php                # Web Routes
```

### Key Design Patterns

- **Repository Pattern** - Service classes handle business logic
- **Policy-based Authorization** - Laravel Policies for access control
- **API Resources** - Consistent API response formatting
- **Form Requests** - Centralized validation logic
- **Observer Pattern** - Model events for side effects
- **Queue Jobs** - Background processing for heavy tasks

## 🔒 Security Features

- **Authentication** - Sanctum token-based authentication
- **Authorization** - Role and permission-based access control
- **Input Validation** - Comprehensive request validation
- **Rate Limiting** - API rate limiting to prevent abuse
- **CORS** - Proper cross-origin resource sharing setup
- **SQL Injection Protection** - Eloquent ORM with parameter binding
- **XSS Protection** - Input sanitization and output escaping

## 🧪 Testing

Run the test suite:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AuthTest.php

# Run with coverage
php artisan test --coverage
```

## 📦 Deployment

### Production Setup

1. **Environment Configuration**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Database Migration**
   ```bash
   php artisan migrate --force
   ```

3. **Queue Workers**
   ```bash
   php artisan horizon
   ```

### Docker Deployment

```dockerfile
FROM php:8.2-fpm

# Install dependencies and extensions
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Use meaningful variable and method names
- Write comprehensive tests for new features
- Document complex business logic
- Use type hints and return types

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel community for the amazing framework
- Spatie for excellent Laravel packages
- All contributors who help improve this project

---

**Built with ❤️ for freelancers who deserve better tools.**