<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Activity;
use App\Post;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::where('id', '!=', auth()->id())->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::where('id', '=', $id)->get();
    }

    public function search(Request $request)
    {
        return User::where('email' ,'like', '%'.$request->name.'%')
        ->orWhere('name', 'like', '%' . $request->name . '%')->paginate(10);
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
        if(auth()->id() === $id){
            User::find($id)->where('id',  $id)->firstOrFail()->update($request->all());
            return $request;
        }
        return "Unauthorized";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == auth()->id()){
            return User::find($id)->where('id',  $id)->firstOrFail()->delete();
        } else {
            return "You cant delete other users";
        }
    }

    public function following()
    {
        return auth()->user()->following();
    }
}
