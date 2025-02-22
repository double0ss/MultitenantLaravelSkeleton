<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'description', 'is_active'];

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'plan_module')->withTimestamps();
    }
}