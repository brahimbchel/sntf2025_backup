<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Role;
class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_EMPLOYE = 'employe';
    public const ROLE_MEDECIN = 'medecin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    
public function hasRole(string|array $roles): bool
{
    return in_array($this->role, (array) $roles);
}

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEmploye(): bool
    {
        return $this->role === self::ROLE_EMPLOYE;
    }

    public function isMedecin(): bool
    {
        return $this->role === self::ROLE_MEDECIN;
    }

    public function employe()
    {
        return $this->hasOne(Employe::class, 'user_id');
    }

    public function medecin()
    {
        return $this->hasOne(Medecin::class, 'user_id');
    }

}

// class User extends Authenticatable
// {
//     use HasApiTokens, HasFactory, Notifiable;
//     use HasRoles;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array<int, string>
//      */
//     protected $fillable = [
//         'name',
//         'email',
//         'password',
//     ];

//     /**
//      * The attributes that should be hidden for serialization.
//      *
//      * @var array<int, string>
//      */
//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     /**
//      * The attributes that should be cast.
//      *
//      * @var array<string, string>
//      */
//     protected $casts = [
//         'email_verified_at' => 'datetime',
//         'password' => 'hashed',
//     ];

//     // public function roles()
//     // {

//     //     return $this->morphToMany(Role::class, 'model', 'model_has_roles', 'model_id', 'role_id');
//     // }

//     public function employe()
//     {
//         return $this->hasOne(Employe::class);
//     }

//     public function medecin()
//     {
//         return $this->hasOne(Medecin::class, 'user_id');
//     }

// }
