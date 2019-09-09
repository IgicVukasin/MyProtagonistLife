<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function feed(Request $request){
        $followingIds = auth()->user()->following();
        $order = 'desc';
        if($request->order === 'asc'){
            $order = $request->order;
        }
        return Post::whereIn('user_id', $followingIds)
            ->where('user_id', '!=', auth()->id())
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name as user_name')
            ->orderBy('posts.created_at', $order)
            ->paginate(10);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::where('user_id', auth()->id())->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->data = $request['data'];
        $post->name = "tmp";
        $post->user_id = auth()->id();
        $post->save();
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::find($id)->where('user_id',  auth()->id())->firstOrFail();
    }

    public function usersPosts(Request $request)
    {
        return Post::where('user_id',  $request->id)->get();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Post::find($id)->where('user_id',  auth()->id())->firstOrFail()->update($request->all());
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Post::find($id)->where('user_id',  auth()->id())->firstOrFail()->delete();
    }
}
