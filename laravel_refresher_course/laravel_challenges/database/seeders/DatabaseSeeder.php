<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Seeders\UserSeeder;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
    }
}
