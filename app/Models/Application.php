<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = ['app_id', 'name', 'domain'];

    public function updates(): HasMany
    {
        return $this->hasMany(Update::class, 'application_id');
    }
}
