<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Arif Hossen',
            'email' => 'arif@mail.com',
        ]);

         $users = User::factory(10)->create();
         $users->push($user);

         Ticket::factory(100)
             ->recycle($users)
             ->create();
    }
}
