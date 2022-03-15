<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
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

    DB::insert('insert into posts(title, body, user_id) values(?, ?, ?)', ['Laravel is the best', 'Laravel is awesome, PERIOD', 1]);
    DB::insert('insert into posts(title, body, user_id) values(?, ?, ?)', ['Java is the best', 'Java is awesome, PERIOD', 1]);
    DB::insert('insert into posts(title, body, user_id) values(?, ?, ?)', ['Python is the best', 'Python is awesome, PERIOD', 1]);
    DB::insert('insert into posts(title, body, user_id) values(?, ?, ?)', ['Javascript is the best', 'Javascript is awesome, PERIOD', 1]);

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
/*
|----------------------------------------------------------------------------------------
| ELOQUENT
|----------------------------------------------------------------------------------------
*/

Route::get('/findwhere', function(){

    $posts = Post::where('id', 3)->orderBy('id', 'desc')->take(1)->get();

    return $posts;

});

Route::get('/findmore', function(){
//
//    $posts = Post::findOrFail(2);
//
//    return $posts;

    $posts = Post::where('users_count', '<', 50)->firstOrFail();
    return $posts;
});

Route::get('/basicinsert', function(){
    $post = Post::find(3);

    $post->title = 'New Eloquent title insert';
    $post->body = 'Wow eloquent is really cool, look at this content';
    $post -> save();
});

Route::get('/create', function(){

    Post::create(['title'=>'the create method 12', 'body'=> 'wow im learning with edwin 12']);

});

Route::get('/update', function () {

    Post::where('id', 2)->where('is_admin', 0)->update(['title'=>'New PHP Title', 'body'=>'Edwin is a G']);
});

Route::get('/delete', function(){

    $post = Post::find(4);

    $post->delete();

});

Route::get('/delete2', function(){

    Post::destroy(3);

});

Route::get('/delete3', function(){

    Post::destroy([4,6]);

    Post::where('is_admin',0 )->delete();

});

Route::get('/softdelete', function(){

    Post::find(3)->delete();

});

Route::get('/readsoftdelete', function (){

    $post = Post::onlyTrashed()->where('is_admin', 0)->get();

    return $post;
});

Route::get('/restore', function(){

    Post::withTrashed()->where('is_admin', 0)->restore();

});

Route::get('/forcedelete', function(){

    Post::onlyTrashed()->where('is_admin', 0)-> forceDelete();

});

/*
|----------------------------------------------------------------------------------------
| ELOQUENT Relationships
|----------------------------------------------------------------------------------------
*/

Route::get('/user/{id}/post', function($id){

    return User::find($id)->post->body;

});
//
//Route::get('/find', function(){
//
//    $post = Post::find(2);
//
//    return $post ->title;
//
//});
//
//    foreach($posts as $post){
//        return $post -> title;
//    }

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
