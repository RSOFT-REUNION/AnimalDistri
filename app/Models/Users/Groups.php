<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Groups extends Model
{
    protected $table = 'user_groups';

    protected $fillable = ['name', 'description', 'erp_id'];

    public function products(): HasMany
    {
        return $this->hasMany(User::class);
    }

}
