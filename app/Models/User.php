<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Classes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'users';

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


    // Relasi ke tabel enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollments::class, 'user_id', 'id');
    }

    // Relasi ke tabel classes melalui enrollments
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'enrollments', 'user_id', 'class_id')
            ->withPivot('enrollment_id') // Optional, kalau ingin mengakses enrollment_id di relasi
            ->withTimestamps()->with(['teachers', 'categories']);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedbacks::class, 'user_id', 'id');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
