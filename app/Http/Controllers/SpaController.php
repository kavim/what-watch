<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class SpaController extends Controller
{

    public function getTvShows()
    {
        sleep(1);

        $return = [
            'status' => false
        ];

        $tvShows = array();

        $tvshowtable = \App\TvShow::orderBy('name')->get();

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

    public function update($request)
    {   
        $tvShow = false;

        $tvShow = \App\TvShow::findOrFail($request['id']);

            $tvShow->update(
                [
                    'name' => $request['name'],
                    'year' => $request['year'],
                    'synopsis' => $request['synopsis'],
                    'seasons_quantity' => $request['seasons_quantity'],
                    'category_id' => $request['category_id'],
                    'status_id' => $request['status_id']
                ]
            );


            return $tvShow;
    }

    public function create($request)
    {
        $tvShow = false;

        $tvShow = \App\TvShow::create(
            [
                'name' => $request['name'],
                'year' => $request['year'],
                'synopsis' => $request['synopsis'],
                'seasons_quantity' => $request['seasons_quantity'],
                'category_id' => $request['category_id'],
                'status_id' => $request['status_id']
            ]
        );

        return $tvShow;

    }

    public function saveTvshow(Request $request)
    {   
        $response = [
            'status' => false,
            'response' => "ok"
        ];

        $validator = Validator::make($request->tvshow,
            [
                'name' => ['required', 'max:200'],
                'synopsis' => 'required|min:0|max:500',
                'year' => 'required|integer|min:1901',
                'category_id' => 'required|integer|min:1',
                'status_id' => 'required|integer|min:1',
                'seasons_quantity' => 'integer|min:1|max:99',
            ]
        );

        if ($validator->fails()) {
            
            $response['response'] = $validator->getMessageBag();
            // $response['response'] = $validator->messages();

            return $response;
        }

        if($request->tvshow['id'] != 0){
            
            $tvShow = $this->update($request->tvshow);
        
        }else{
            
            $tvShow = $this->create($request->tvshow);
        }


        if($tvShow){
            $response = [
                'status' => true,
                'tvshow' => $tvShow,
                'response' => "ok"
            ];
        }

        return $response;

    }

    public function updateTvshow(Request $request, $id)
    {
        $validator = Validator::make($request->tvshow,
            [
                'name' => ['required', 'max:200'],
                'synopsis' => 'required|min:0|max:500',
                'year' => 'required|integer|min:1901',
                'category_id' => 'required|integer|min:1',
                'status_id' => 'required|integer|min:1',
                'seasons_quantity' => 'integer|min:1',
            ]
        );

        if ($validator->fails()) {
            
            $response['response'] = $validator->messages();

            return $response;
        }

        if($request->tvshow['id'] != 0){
            $tvShow = $this->update($request->tvshow);
        }

        if($tvShow){
            $response = [
                'status' => true,
                'tvshow' => $tvShow,
                'response' => "ok"
            ];
        }

        return $response;

    }

    public function destroy($id)
    {
        \App\TvShow::destroy($id);

        return ['response' => 'ok'];
    }
}
