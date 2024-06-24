<?php

namespace App\Models\Orders;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    use HasFactory;

    protected $table = 'order_status';

    protected $fillable = ['status'];

}
