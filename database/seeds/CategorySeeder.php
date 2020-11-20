<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = ['Ação', 'Aventura', 'Comédia', 'Documentário', 'Drama', 'Fantasia', 'Ficção científica', 'Musical', 'Romance', 'Suspense', 'Terror', 'Comédia romântica', 'Policial', '`Guerra', 'Arte'];

        foreach ($array as $a){
            \App\Category::create([
                'name' => $a,
            ]);
        }
    }
}
