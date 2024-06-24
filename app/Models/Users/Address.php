<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'user_addresses';
    protected $fillable = ['user_id', 'alias', 'civility', 'last_name', 'first_name', 'address', 'address2', 'cities', 'country', 'phone', 'other_phone', 'other', 'type', 'favorite'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
