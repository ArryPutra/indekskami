<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admin\Admin;
use App\Models\Responden\Responden;
use App\Models\Verifikator\Verifikator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

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

    public function peran()
    {
        return $this->hasOne(Peran::class, 'id', 'peran_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    public function responden()
    {
        return $this->hasOne(Responden::class, 'user_id', 'id');
    }

    public function verifikator()
    {
        return $this->hasOne(Verifikator::class, 'user_id', 'id');
    }
}
