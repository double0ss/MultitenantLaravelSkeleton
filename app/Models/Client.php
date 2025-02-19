<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Client extends Model
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

    public function users()
    {
        return $this->hasMany(User::class);
    }
}