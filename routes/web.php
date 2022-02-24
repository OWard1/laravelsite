<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

//Route::get('/post/{id}', '\App\Http\Controllers\PostsController@index');
//
//Route::resource('posts', '\App\Http\Controllers\PostsController');

Route::get('/contact', '\App\Http\Controllers\PostsController@contact');

Route::get('/post/{id}/{name}/{password}', '\App\Http\Controllers\PostsController@show_post');

Route::get('/update', function(){

    $updated = DB::update('update posts set title = "Update title" where id = ?', [1]);

    return $updated;
});

Route::get('/insert', function() {

    DB::insert('insert into posts(title, body) values(?, ?)', ['PHP with Laravel', 'Laravel is awesome']);

});

Route::get('/read', function(){

   $results = DB::select('select * from posts where id = ?', [1]);

   foreach($results as $post){
        return var_dump($results);
    }

});

Route::get('/delete', function(){

    $deleted = DB::delete('delete from posts where id = ?', [1]);

    return $deleted;
});

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::get('/about', function () {
//    return 'Hi about page';
//});
//
//Route::get('/contact', function () {
//    return 'hi i am contact';
//});
//
//Route::get('post/{id}/{name}', function($id, $name){
//    return "this is post number - ". $id . " by " . $name;
//});
//
//Route::get('admin/posts/example', array('as'=>'admin.home', function(){
//    $url = route('admin.home');
//    return "this url is " . $url;
//}));
