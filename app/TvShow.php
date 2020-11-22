<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TvShow extends Model
{
    protected $fillable = ['name', 'synopsis', 'year', 'seasons_quantity', 'category_id', 'status_id'];

    
    public function getcover()
    {
        $cover = \App\Cover::where('tvshow_id', $this->id)->orderBy("id", "DESC")->first();

        return $cover ? '/storage/'.$cover->src : '/image/default-movie.png';
    }
}
