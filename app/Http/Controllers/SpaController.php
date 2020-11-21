<?php

namespace App\Http\Controllers;

use CreateTvShowsTable;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

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

    public function update($request)
    {   
        // $tvShow = false;

        // try {

        //     $tvShow = \App\TvShow::findOrFail($request['id']);

        //     $tvShow->update(
        //         [
        //             'name' => $request['name'],
        //             'year' => $request['year'],
        //             'synopsis' => $request['synopsis'],
        //             'seasons_quantity' => $request['seasons_quantity'],
        //             'category_id' => $request['category_id'],
        //             'status_id' => $request['status_id']
        //         ]
        //     );

        // } catch (ModelNotFoundException $th) {
            
        //     \Log::info($th);

        //     throw $th;

        // } finally {

        //     return $tvShow;

        // }
        
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
        
        // try {
        //     $tvShow = \App\TvShow::create(
        //         [
        //             'name' => $request['name'],
        //             'year' => $request['year'],
        //             'synopsis' => $request['synopsis'],
        //             'seasons_quantity' => $request['seasons_quantity'],
        //             'category_id' => $request['category_id'],
        //             'status_id' => $request['status_id']
        //         ]
        //     );

        //     return $tvShow;

        // } catch (CreateTvShowsTable $th) {
            
        //     \Log::info($th);

        //     throw $th;

        // } finally {

        //     return $tvShow;
            
        // }

        // return $tvShow;

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

        // $return = [
        //     'status' => false,
        //     'tvshow' => $tvShow = []
        // ];

        // try {

        //     if($request->id != 0){
        //         $tvShow = $this->update($request);
        //     }
    
        //     $tvShow = $this->create($request);


        //     \Log::info($tvShow);

        //     $return = [
        //         'status' => true,
        //         'tvshow' => $tvShow
        //     ];

        // } catch (HandleExceptions $th) {
            
        //     \Log::info("wadwdawoduiaowaowidn");

        //     throw $th;


        // } finally {

        //     return $return;

        // }

        $response = [
            'status' => false,
            'response' => "ok"
        ];

        \Log::info($request->tvshow);

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

    public function destroy($id)
    {
        \App\TvShow::destroy($id);

        return ['response' => 'ok'];
    }
}
