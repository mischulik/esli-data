<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->afterCreating(function (User  $user) {
            $user->elsie_credentials()->create([
                'email' => 'avtosteklozp@i.ua',
                'passwd' => '8db9c421',
            ]);
        })->create([
            'email' => 'avtosteklozp@i.ua',
            'password' => '8db9c421',
        ]);
    }
}
