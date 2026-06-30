<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Les rôles définis dans le document (Chapitre 3, Section 2.1)
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_SECRETAIRE = 'secretaire';
    const ROLE_CHEF_DE_SERVICE = 'chef_de_service';
    const ROLE_DIRECTEUR = 'directeur';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Ajouté pour la gestion CNSS
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

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isSecretaire(): bool
    {
        return $this->role === self::ROLE_SECRETAIRE;
    }

    public function isChefDeService(): bool
    {
        return $this->role === self::ROLE_CHEF_DE_SERVICE;
    }

    public function isDirecteur(): bool
    {
        return $this->role === self::ROLE_DIRECTEUR;
    }

    public function archives(): HasMany
    {
        // On suppose que la clé étrangère dans la table archives sera 'user_id'
        return $this->hasMany(Archive::class);
    }
}