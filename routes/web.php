<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use App\Models\Country;
use App\Models\Photo;
use App\Models\Tag;
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

    DB::insert('insert into posts(title, body, user_id) values(?, ?, ?)', ['PHP is the best', 'Laravel is awesome, PERIOD', 1]);
    DB::insert('insert into posts(title, body, user_id) values(?, ?, ?)', ['Javascript is the best', 'Java is awesome, PERIOD', 1]);
    DB::insert('insert into posts(title, body, user_id) values(?, ?, ?)', ['Python is the best', 'Python is awesome, PERIOD', 1]);
    DB::insert('insert into posts(title, body, user_id) values(?, ?, ?)', ['Java is the best', 'Javascript is awesome, PERIOD', 1]);
    DB::insert('insert into users(name, email, password) values(?, ?, ?)', ['Oli', 'Oli@thing.com', 'password']);
    DB::insert('insert into users(name, email, password) values(?, ?, ?)', ['Peter', 'Peter@thing.com', 'password']);
    DB::insert('insert into roles (name) values(?)', ['admin']);
    DB::insert('insert into roles (name) values(?)', ['subscriber']);
    DB::insert('insert into role_user (user_id, role_id) values(?, ?)', [1, 1]);
    DB::insert('insert into role_user (user_id, role_id) values(?, ?)', [2, 2]);
    DB::insert('insert into countries (name) values(?)', ["UK"]);
    DB::insert('insert into countries (name) values(?)', ["GR"]);
    DB::insert('insert into photos (path, imageable_id, imageable_type) values(?, ?, ?)', ["me.jpg", 1, "App\Models\User"]);
    DB::insert('insert into photos (path, imageable_id, imageable_type) values(?, ?, ?)', ["notme.jpg", 2, "App\Models\Post"]);
    DB::insert('insert into videos (name) values(?)', ["oli.mov"]);
    DB::insert('insert into videos (name) values(?)', ["new.mov"]);
    DB::insert('insert into taggables (tag_id, taggable_id, taggable_type) values(?, ?, ?)', [1, 1, "App\Models\Video"]);
    DB::insert('insert into taggables (tag_id, taggable_id, taggable_type) values(?, ?, ?)', [2, 2, "App\Models\Post"]);
    DB::insert('insert into tags (name) values(?)', ["PHP"]);
    DB::insert('insert into tags (name) values(?)', ["Javascript"]);

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
// One to one relationship
Route::get('/user/{id}/post', function($id){

    return User::find($id)->post->body;

});

Route::get('post/{id}/user', function($id){

    Return Post::find($id)->user->name;

});

// One to many reltionship
Route::get('/posts', function(){

    $user = User::find(1);

    foreach($user->posts as $post){
        echo $post->title . "<br>";
    }

});

// many to many

Route::get('user/{id}/role', function($id) {

    $user = User::find($id)->roles()->orderBy('id', 'desc')->get();

    return $user;

});


 // Accessing the intermediate table /pivot


Route::get('user/pivot', function(){

    $user = User::find(2);

    foreach($user->roles as $role){

        echo $role->pivot->created_at;

    }

});

Route::get('user/country', function(){

        $country = Country::find(2);

        foreach($country->posts as $post)
        {
            return $post->title;
        }

});


// Polymorphic relationship

Route::get('post/{id}/photos', function($id) {
    $user = Post::find($id);

    foreach ($user->photos as $photo) {
        echo $photo->path . "<br>";
    }
});

Route::get('photo/{id}/post', function($id){

    $photo = Photo::findOrFail($id);

    return $photo->imageable;

});


// Polymorphic many to many relationship

Route::get('/post/tag', function(){

    $post = Post::find(1);

    foreach($post->tags as $tag){
        echo $tag->name;
    }

});

Route::get('/tag/post', function(){

    $tag = Tag::find(2);

    foreach($tag->posts as $post){
        echo $post->title;
    }

});

//    foreach($user->roles as $role) {
//
//     return $role->name;
//
// }

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
