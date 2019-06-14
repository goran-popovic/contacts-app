<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Http\Resources\Group as GroupResource;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get groups
        $groups = Group::orderBy('created_at', 'desc')->get();

        // return collection of groups as a resource
        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = $request->isMethod('put') ? Group::findOrFAil($request->id) : new Group;

        $group->id = $request->input('id');
        $group->name = $request->input('name');

        if($group->save()) {
            return new GroupResource($group);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get group
        $group = Group::findOrFail($id);

        // Return single group as a resource

        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get group
        $group = Group::findOrFail($id);

        // Return deleted group as a resource
        if($group->delete()) {
            return new GroupResource($group);
        }
    }
}
