<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    /**
     * Get the decrypted email attribute.
     *
     * @param string $value
     * @return string
     */
    public function getDescriptionAttribute($value): string
    {
        return crypt::decryptString($value);
    }

    /**
     * Set the encrypted description attribute.
     *
     * @param string $value
     * @return void
     */
    public function setDescriptionAttribute($value): void
    {
        $this->attributes['description'] = Crypt::encryptString($value);
    }
}
