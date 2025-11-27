<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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


    public function roles(): HasManyThrough
    {
        return $this->hasManyThrough(
            Role::class,
            UsersToRoles::class,
            'user_id',
            'id',
            'id',
            'role_id'
        );
    }


    /**
     * @param string $code
     * @return bool
     */
    public function hasRole(string $code): bool
    {
        return in_array($code, $this->roles()->get()->toArray());
    }


    /**
     * @param string $code
     */
    public function hasPermission(string $object, string $action): bool
    {
        return (bool) DB::table('roles_to_permissions')
            ->whereIn(
                'roles_to_permissions.role_id',
                array_column($this->roles()->get()->toArray(), 'id')
            )
            ->join(
                'permissions',
                'roles_to_permissions.permission_id',
                '=',
                'permissions.id'
            )
            ->where('permissions.object', '=', $object)
            ->where('permissions.action', '=', $action)
            ->count()
        ;
    }
}
