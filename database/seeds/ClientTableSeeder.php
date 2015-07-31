<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks = 0");
        \CodeProject\Entities\Client::truncate();
        factory(\CodeProject\Entities\Client::class, 10)->create();
    }
}
