<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'tienhh1994@gmail.com')->first()) {
            User::create([
                'name'     => 'Lê Văn Tiến',
                'password' => bcrypt('admin'),
                'email'    => 'tienhh1994@gmail.com'
            ]);
        }
    }
}
