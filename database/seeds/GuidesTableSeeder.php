<?php

use Illuminate\Database\Seeder;

class GuidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Guide::class, 10)->create();
    }
}