<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks = 0");
        \CodeProject\Entities\User::truncate();
        \CodeProject\Entities\User::create([
            'name' => 'Michel',
            'email' => 'sobreira.michel@gmail.com',
            'password' => bcrypt(str_random(123456)),
            'remember_token' => str_random(10)
        ]);
        factory(\CodeProject\Entities\User::class, 9)->create();
    }
}
