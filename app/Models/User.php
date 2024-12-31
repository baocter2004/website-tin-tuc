<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const USER_ROLE = ['admin', 'editor', 'author', 'subcriber'];
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'image',
        'is_active'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $attributes = [
        'is_active' => 0
    ];

    public function isAdmin()
    {
        return $this->role === self::USER_ROLE[0];
    }
    public function isEditor()
    {
        return $this->role === self::USER_ROLE[1];
    }
    public function isAuthor()
    {
        return $this->role === self::USER_ROLE[2];
    }
    public function isSubcriber()
    {
        return $this->role === self::USER_ROLE[3];
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function articles()
    {
        return $this->hasMany(Article::class, 'auth_id');
    }
    public function views()
    {
        return $this->hasMany(View::class);  // Một người dùng có nhiều lượt xem
    }
}
