<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        if (! app()->environment('local', 'testing')) {
            return;
        }

        User::query()->updateOrCreate(
            ['email' => 'info@example.com'],
            [
                'name' => 'Encodia',
                'email' => 'info@example.com',
                'password' => Hash::make('abc'),
                'email_verified_at' => now(),
                'super' => 1,
                'preferences' => [
                    'locale' => 'en',
                ],
            ],
        );
    }
}
