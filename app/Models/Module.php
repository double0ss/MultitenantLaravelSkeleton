<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Module extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}