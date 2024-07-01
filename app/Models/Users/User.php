<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use  Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'groups_id',
        'name',
        'civility',
        'last_name',
        'first_name',
        'birthday',
        'phone',
        'newsletter',
        'email',
        'password',
        'active',
        'erp_id',
        'erp_loyalty_points',
        'erp_loyalty_card',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function checkNewsletter($newsletter)
    {
        if($newsletter == 0) {
            echo '<span style="color: red;"><i class="fa-solid fa-rectangle-xmark fa-2x"></i></span>';
        } else {
            echo '<span style="color: green;"><i class="fa-solid fa-square-check fa-2x"></i></span>';
        }
    }
    public function checkEmailVerified($emailverified)
    {
        if($emailverified == Null) {
            echo '<span style="color: red;"><i class="fa-solid fa-rectangle-xmark fa-2x"></i></span>';
        } else {
            echo '<span style="color: green;"><i class="fa-solid fa-square-check fa-2x"></i></span>';
        }
    }

    public function adresses() {
        return $this->hasMany(Address::class);
    }

    public function groups() {
        return $this->BelongsTo(Groups::class);
    }
}
