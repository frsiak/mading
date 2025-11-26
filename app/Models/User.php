<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama', 'username', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    
    public function getAuthIdentifierName()
    {
        return 'id_user';
    }
    
    public function getAuthIdentifier()
    {
        return $this->getAttribute('id_user');
    }

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
    
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_user', 'id_user');
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_user', 'id_user');
    }
    
    public function hasLiked($artikelId)
    {
        return $this->likes()->where('id_artikel', $artikelId)->exists();
    }
}
