<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TvShow extends Model
{
    protected $fillable = ['name', 'synopsis', 'year', 'seasons_quantity', 'category_id', 'status_id'];
}
