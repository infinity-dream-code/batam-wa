<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * @var mixed|string|null
     */
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'email_verified_at',
        'last_login',
        'token',
        'login_token',
        'is_active',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // public function isAdmin()
    // {
    //     return $this->role_id == 1;
    // }

    // public function isUser()
    // {
    //     return $this->role_id == 2;
    // }

    // public function role()
    // {
    //     return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    // }

    // public function permission()
    // {
    //     $collection = collect(json_encode($this->role()->permissions));
    //     return $collection;
    // }
}
