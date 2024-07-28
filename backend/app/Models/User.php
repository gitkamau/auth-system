<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Role;
use Spatie\Permission\Traits\HasRoles;
// use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements  MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role' => 'required|in:student,university_admin,recruiter',
        'university' => 'required_if:role,student,university_admin',
        'major' => 'required_if:role,student',
        'company' => 'required_if:role,recruiter',
        'is_mfa_enabled',
        'phone_number',
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

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if the user has a role.
     */
    // public function hasRole($role)
    // {
    //     if (is_string($role)) {
    //         return $this->roles()->where('name', $role)->exists();
    //     }

    //     return $this->roles()->whereIn('name', $role)->exists();
    // }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
