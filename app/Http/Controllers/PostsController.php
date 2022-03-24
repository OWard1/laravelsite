<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response|string
    {
        //
       $posts = Post::all();
       return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Post::create($request->all());

        return redirect('/posts');

//        Post::create($request->all());
//    $input = $request-all();
//    $input['title'] = $request->title;
//    Post::create($request->all());
//
//    $post = new Post;
//
//    $post->title = $request->title;
//
//    $post->save();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::findOrFail($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->update($request->all());

        return redirect('/posts');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id)->delete();

        return redirect('/posts');

    }
    public function contact(){
        $people = ['Edwin', 'Jose', 'James', 'Peter', 'Maria'];

        return view('contact', compact('people'));
    }

    public function show_post($id, $name, $password){

//        return view('post')->with('id', $id);
        return view('post', compact('id', 'name', 'password'));
    }
}

//  Route::get('/checking', '\App\Http\Controllers\HomeController@index');
// instead of
// Route::get('/', 'HomeController@index')
