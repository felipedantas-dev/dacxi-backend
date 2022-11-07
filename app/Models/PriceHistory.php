<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'crypto_id',
        'currency_id',
        'price',
        'created_at',
        'updated_at'
    ];
}
