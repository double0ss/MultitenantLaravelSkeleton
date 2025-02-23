# Multi-tenant Laravel Skeleton

A Laravel-based multi-tenant application skeleton with Filament admin panel integration.

## Features

- Multi-tenant architecture with database per tenant
- Filament admin panel for platform management
- Role-based access control
- Company/tenant management
- User management per tenant
- Automated tenant database creation

## Requirements

- PHP 8.3+
- PostgreSQL 13+
- Composer
- Node.js & NPM

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/MultitenantLaravelSkeleton.git
cd MultitenantLaravelSkeleton
##instalacion de dependencias
composer install
## configura la conexion a la base de datos y variables de ambiente
cp .env.example .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
##genera una nueva key para la app
php artisan key:generate
## Ejecuta las migraciones
php artisan migrate
##crea un usuario admin
php artisan make:filament-user

## compilar componentes js
pnpm install
pnpm run build
## ejecutar el proyecto
php artisan serve
## Usage
1. Access the admin panel at: http://your-domain/dashboard
2. Login with your admin credentials
3. Create companies/tenants through the Platform Management section
4. Each tenant will automatically get:
   
   - Their own database
   - Basic user management
   - Role-based permissions
## Directory Structure
- app/Filament/Resources/ - Filament admin panel resources
- database/migrations/ - System-wide migrations
- database/migrations/tenant/ - Tenant-specific migrations
## Security
Make sure to:

1. Grant proper database permissions to create/delete databases
2. Secure your admin credentials
3. Configure proper domain routing for tenants
## License
The MIT License (MIT). Please see License File for more information.