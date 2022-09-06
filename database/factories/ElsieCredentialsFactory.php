<?php

namespace Database\Factories;

use App\Models\ElsieCookie;
use App\Models\ElsieCredentials;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElsieCredentialsFactory extends Factory
{
    protected $model = ElsieCredentials::class;

    public function definition(): array
    {
        return [
            'user_id' => optional(User::query()->inRandomOrder()->first() ?? null, function (User $user) {
                return $user->id;
            }),
            'email' => $this->withFaker()->safeEmail(),
            'passwd' => $this->withFaker()->word(),
        ];
    }
}
