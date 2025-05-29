<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * Get the siswa record associated with the user.
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    /**
     * Get the wakil_kesiswaan record associated with the user.
     */
    public function wakilKesiswaan()
    {
        return $this->hasOne(WakilKesiswaan::class);
    }

    /**
     * Get the panitia record associated with the user.
     */
    public function panitia()
    {
        return $this->hasOne(Panitia::class);
    }
}