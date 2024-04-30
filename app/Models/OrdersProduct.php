<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersProduct extends Model
{
    use HasFactory;

    protected $table = 'orders_product';

    public $timestamps = false;

    protected $fillable = [
        'orders_id',
        'product_id',
        'quantity_order'
    ];
}
