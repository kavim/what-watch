<?php

use Illuminate\Database\Seeder;

class TvshowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ts = '[{"name":"Anne with an E","year":2015,"synopsis":"Depois de treze anos sofrendo no sistema de assistência social, a orfã Anne é mandada para morar com uma solteirona e seu irmão. Munida de sua imaginação e de seu intelecto, a pequena Anne vai ...","seasons_quantity":2,"category_id":5,"status_id":1},{"name":"Breaking Bad","year":2015,"synopsis":"Walter White (Bryan Cranston) é um professor de química na casa dos 50 anos que trabalha em uma escola secundária no Novo México. Para atender às necessidades de Skyler (Anna Gunn), sua esposa ...","seasons_quantity":5,"category_id":5,"status_id":1},{"name":"Game of Thrones","year":2015,"synopsis":"Nove famílias da nobreza lutam pelo controle dos territórios de Westeros, um lugar onde os verões podem durar vários anos e o inverno, a vida inteira. Enquanto isso, uma antigo inimigo retorna para ameaçá-los.","seasons_quantity":7,"category_id":1,"status_id":1},{"name":"Vikings","year":2015,"synopsis":"Descendente direto do deus Odin, de acordo com as lendas, Ragnar Lothbrok (Travis Fimmel) é o maior guerreiro da tribo dos Vikings. Com o apoio da família, ele honra as tradições como pode e acaba sendo coroado Rei.","seasons_quantity":6,"category_id":1,"status_id":1}]';

        $tss = json_decode($ts, true);

        foreach ($tss as $ts){
            \App\TvShow::create([
                'name' => $ts['name'],
                'year' => $ts['year'],
                'synopsis' => $ts['synopsis'],
                'seasons_quantity' => $ts['seasons_quantity'],
                'category_id' => $ts['category_id'],
                'status_id' => $ts['status_id']
            ]);
        }
    }
}
