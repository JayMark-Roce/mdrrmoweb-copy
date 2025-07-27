<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
<<<<<<< HEAD
    public function run()
    {
        // \App\Models\User::factory(10)->create();
    }
=======
public function run()
{
    $this->call([
        DriverSeeder::class,
    ]);
}

>>>>>>> 887899e7221396f620d0d6dad872e632d494197b
}
