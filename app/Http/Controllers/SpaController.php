<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index()
    {
        return view('index');
    }



    public function getTvShows()
    {
        $return = [
            'status' => false
        ];

        $tvShows = array();

        $tvshowtable = \App\TvShow::orderBy('name')->get();

        // \Log::info($tvshowtable);

        if($tvshowtable){
            foreach ($tvshowtable as $key => $ts) {
                
                array_push($tvShows, 
                [
                    'id' => $ts->id,
                    'name' => $ts->name,
                    'year' => $ts->year,
                    'synopsis' => $ts->synopsis,
                    'seasons_quantity' => $ts->seasons_quantity,
                    'category_id' => $ts->category_id,
                    'status_id' => $ts->status_id,
                ]);

            }    
        }

        $return = [
            'status' => true,
            'tvshows' => $tvShows
        ];

        return $return;
    }


    public function getCategories()
    {
        
        $cats = \App\Category::get();
        
        return $cats->makeHidden(['updated_at', 'created_at'])->toArray();


    }

    public function getStatus()
    {
        
        $cats = \App\Status::get();
        
        return $cats->makeHidden(['updated_at', 'created_at'])->toArray();

    }

    public function getYear()
    {
        $years = array();

        for ($i = 2025; $i > 1900; $i--) {
                
            array_push($years, 
            [
                'text' => strval($i),
                'value' => $i
            ]);

        }   

        return$years;
    }
}
