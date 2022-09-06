<?php

namespace App\Models;

use App\Actions\Auth\ElsieLoginAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable;
    use InteractsWithMedia;

    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    protected $table = 'users';

    protected $fillable = [
        'name', 'password', 'email',
    ];

    public function elsie_credentials(): HasOne
    {
        return $this->hasOne(ElsieCredentials::class, 'user_id', 'id');
    }
}
