<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

   factory(App\User::class,30)->create();

factory(App\category::class,10)->create();

     factory(App\Post::class,70)->create();

  factory(App\comment::class,300)->create();
    }
}
