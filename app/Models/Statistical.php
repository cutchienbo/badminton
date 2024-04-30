<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistical extends Model
{
    use HasFactory;

    protected $table = 'statistical';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'cost',
        'date',
        'duration',
        'product_sum_cost'
    ];
}
