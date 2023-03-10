<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'first',
            'email' => 'first@test.test',
            'password' => Hash::make('first'),
        ]);

        User::create([
            'name' => 'second',
            'email' => 'second@test.test',
            'password' => Hash::make('second'),
        ]);
    }
}
