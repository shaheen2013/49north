<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* DB::table('users')->insert([
            'name' => str_random(6),
            'email' => strtolower(str_random(6)).'@gmail.com',
            'password' => bcrypt('admin@123')
        ]);*/
		
		DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@123'),
			'user_type' => 'is_admin'
        ]);

    }
}
