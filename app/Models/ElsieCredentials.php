<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElsieCredentials extends Model
{
    use HasFactory;

    protected $table = 'elsie_credentials';

    protected $fillable = [
        'user_id',
        'cookie',
        'email',
        'passwd',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getHeaderValueAttribute()
    {
        return optional($this->cookie ?? null, function (string $cookie) {
            return implode('=', [
                'mojolicious',
                $cookie,
            ]);
        });
    }
}
