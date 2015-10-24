<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
  //Route::get('elfinder','Barryvdh\elfinder\ElfinderController@showConnector');
  Route::get('elfinder','Barryvdh\elfinder\ElfinderController@showTinyMCE4');

Route::get('/', function () {
    return view('welcome');
});

Route::resource('editor','ElfinderController');

Route::get('editore','ElfinderController@editore');
//Route::get('editor2','ElfinderController@editor2');

#Route::get("disk");

  Route::get('glide/{path}', function($path){
        $server = \League\Glide\ServerFactory::create([
            'source' => app('filesystem')->disk('public')->getDriver(),
            'cache' => storage_path('glide'),
        ]);
        return $server->getImageResponse($path, Input::query());
    })->where('path', '.+');

 // Route::get('/elfinder/tinymce','Barryvdh\Elfinder\ElfinderController@showTinyMCE4');

  #Route::get('elfinder','ElfinderController@showConnector');