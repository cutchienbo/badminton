<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_type',
        'image_url',
        'name',
        'quantity',
        'cost'
    ];

    public function order(): BelongsToMany
    {
        return $this->belongsToMany(Orders::class)->withPivot('quantity_order');
    }

    public function type():BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
}
