<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'order_delivery';
    protected $fillable = ['name', 'description', 'image', 'price_ttc', 'active'];
}
