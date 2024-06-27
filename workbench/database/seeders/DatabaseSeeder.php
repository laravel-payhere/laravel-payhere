<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Workbench\App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->state([
                'name' => 'Dasun Tharanga',
                'email' => 'hello@dasun.dev',
            ])
            ->create();
    }
}
