<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class Company extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'domain',
        'database',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    protected static function booted()
    {
        static::creating(function ($company) {
            $company->database = str_replace('-', '_', $company->id);
        });
    
        static::created(function ($company) {
            try {
                // Create the new database with quotes to handle special characters
                DB::statement('CREATE DATABASE "' . $company->database . '"');
    
                // Run migrations on the new database
                Artisan::call('tenants:migrate', [
                    '--database' => $company->database
                ]);
            } catch (\Exception $e) {
                report($e);
                throw $e;
            }
        });
    
        static::deleting(function ($company) {
            try {
                // Drop database with quotes to handle special characters
                DB::statement('DROP DATABASE IF EXISTS "' . $company->database . '"');
            } catch (\Exception $e) {
                report($e);
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}