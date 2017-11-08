<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Illuminate\Support\Facades\Artisan::call('migrate');

Route::get('/template/{file}/', function($file) { return view($file); });

Route::get('/view/{filder}/{file?}/{param?}', function($folder, $file = '', $param = '') {
	return view($folder.(empty($file) ? '' : '.'.$file));
})->middleware('auth.views');

Route::any('api/{unit}/{method}', 'RoutesController')->middleware('messages');

Route::any('{catchall}', function() {
	if ( ! Auth::check() || Request::segment(1) == "auth" ) {
		return view('template_blank');
	} else {
		return view('template');
	}
})->where('catchall', '(.*)');

//Route::post('pdfview',array('as'=>'pdfview','uses'=>'ItemController@pdfview'));
