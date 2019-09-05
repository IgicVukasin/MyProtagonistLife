<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use App\ActivityTypes;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function feed(){
        $followingIds = auth()->user()->following();
        return Activity::whereIn('user_id', $followingIds)
            ->where('user_id', '!=', auth()->id())
            ->leftJoin('users', 'users.id', '=', 'activities.user_id')
            ->select('activities.*', 'users.name as user_name')
            ->paginate(10);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Activity::where('user_id', auth()->id())->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activity = new Activity();
        $activity->name = $request['name'];
        $activity->description = $request['description'];
        $activity->length = $request['length'];
        // $activity->type = $request['type'];
        // $activity->expGained = Activity::calculateExpGained($request['type'], $request['length']);
        $activity->type = 'Workout';
        $activity->expGained = Activity::calculateExpGained('Workout', $request['length']);
        $activity->user_id = auth()->id();
        $activity->save();
        return $activity;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Activity::find($id)->where('user_id',  auth()->id())->firstOrFail();
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
        Activity::find($id)->where('user_id',  auth()->id())->firstOrFail()->update($request->all());
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Activity::find($id)->where('user_id',  auth()->id())->firstOrFail()->delete();
    }
}
