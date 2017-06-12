<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		App\User::create([
			'name' => 'mtnw',
			'email' => 'mtnw@mtnw.nl',
			'password' => bcrypt('nextweb'),
			'remember_token' => str_random(10),
		]);


		factory(App\Product::class, 12)->create();
    }
}
