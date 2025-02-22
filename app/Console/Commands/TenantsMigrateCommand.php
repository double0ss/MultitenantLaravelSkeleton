<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class TenantsMigrateCommand extends Command
{
    protected $signature = 'tenants:migrate {--database=}';
    protected $description = 'Run migrations for tenant database';

    public function handle()
    {
        $database = $this->option('database');
        
        if (!$database) {
            $this->error('Database name is required');
            return 1;
        }

        // Temporarily change database configuration
        Config::set('database.connections.tenant', [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => $database,
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ]);

        // Run migrations for tenant database
        $this->call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);

        return 0;
    }
}