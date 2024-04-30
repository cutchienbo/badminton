<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Yard extends Model
{
    use HasFactory;

    protected $table = 'yard';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'number',
        'active',
        'cost',
        'active'
    ];

    public function order(): HasMany
    {
        return $this->hasMany(Orders::class);
    }
}
