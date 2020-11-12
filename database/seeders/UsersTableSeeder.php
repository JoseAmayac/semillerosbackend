<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'lastname' => 'General',
            'cellphone' => '3202115236',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminpassword'),
        ]);

        $user->assignRole('Administrador');
        $user->save();
    }
}
