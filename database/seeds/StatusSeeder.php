<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = ['Já assisti', 'Quero ver'];

        foreach ($array as $a){
            \App\Status::create([
                'name' => $a,
            ]);
        }
    }
}
