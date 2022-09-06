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
                'eyJkZWxpdmVyeV9hZGRyZXNzIjoiICIsImRlbGl2ZXJ5X2lzbmVlZGVkIjowLCJkZWxpdmVyeV9waG9uZSI6IigwNjEpIDc4Ny02NS03NiwgKDA1MCkgMzQyLTg0LTg5IiwiY29tbWVudCI6IiIsIm5hbWUiOiJhdnRvc3Rla2xvenBAaS51YSIsImV4cGlyZXMiOjE2NDMxMzI4NTl9--440bbb6271fa2a0dbc8aaa33b560e8ac',
            ]);
        });
    }
}
