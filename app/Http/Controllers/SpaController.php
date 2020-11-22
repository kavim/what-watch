<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Storage;

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
                    'cover' => $ts->getcover()
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
                    'status_id' => $request['status_id'],
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

            $return_tvshow = [
                'id' => $tvShow->id,
                'name' => $tvShow->name,
                'year' => $tvShow->year,
                'synopsis' => $tvShow->synopsis,
                'seasons_quantity' => $tvShow->seasons_quantity,
                'category_id' => $tvShow->category_id,
                'status_id' => $tvShow->status_id,
                'cover' => $tvShow->getcover()
            ];

            $response = [
                'status' => true,
                'tvshow' => $return_tvshow,
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

            $return_tvshow = [
                'id' => $tvShow->id,
                'name' => $tvShow->name,
                'year' => $tvShow->year,
                'synopsis' => $tvShow->synopsis,
                'seasons_quantity' => $tvShow->seasons_quantity,
                'category_id' => $tvShow->category_id,
                'status_id' => $tvShow->status_id,
                'cover' => $tvShow->getcover()
            ];
        }

        if($tvShow){
            $response = [
                'status' => true,
                'tvshow' => $return_tvshow,
                'response' => "ok"
            ];
        }

        return $response;

    }

    public function destroy($id)
    {
        $cover = \App\Cover::where('tvshow_id', $id)->first();

        if($cover){
            $cover->delete();
        }        
        
        \App\TvShow::destroy($id);

        return ['response' => 'ok'];
    }

    public function saveCover(Request $request)
    {

        \Log::info($request);

        $request['data'] = json_decode($request['data']);

        $tvshow_id = $request['data']->tvshow_id;

        $this->validate($request, ['cover' => 'image|max:20480',]);

        if($request->hasFile('cover')) {
            $src = $request->file('cover')->store("cover/image/" . Carbon::now()->format('Y-m-d'), 'public');
            $img = \App\Cover::create([
                'src' => $src,
                'tvshow_id' => $tvshow_id
            ]);

            // $image = Imagem::make(storage_path("app/public/".$src))->save();
            $image = Image::make(storage_path("app/public/".$src))->fit(200, 300)->save();
            $image->save();
        }

        return [
            'status' => true,
            'src' => $img->src
        ];
    }
}
