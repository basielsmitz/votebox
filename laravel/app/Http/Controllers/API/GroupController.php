<?php

namespace App\Http\Controllers\API;

use App\Models\Group;
use App\Models\Group_user;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Group::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "Group can only be made in the backoffice";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::
            with('referendums')
            ->with('users')
            ->find($id);
        $users = $group->users()->get();

        $object = (object) [
            'group' => $group,
            'users' => $users,
        ];


        return response()->json($object)?: response()
            ->json([
                'error' => "Group `${id}` not found",
            ])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
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
        $group = Group::find($id);

        //check input from request and change in the table if needed
        if($request->input('name') == null || $group->name == $request->input('name') ||
            $request->input('name') == '')
        {
            $group->name = $group->name;
        } else {
            $group->name = $request->input('name');
        }

        if($request->input('description') == null || $group->description == $request->input('description') ||
            $request->input('description') == '')
        {
            $group->description = $group->description;
        } else {
            $group->description = $request->input('description');
        }

        $group->save();

        return 'Group with id ' . $group->id . ' updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);

        if ($group) {
            if ($group->delete()) {
                return response()
                    ->json($group)
                    ->setStatusCode(Response::HTTP_OK);
            }

            return response()
                ->json([
                    'error' => "Group `${id}` could not be deleted",
                ])
                ->setStatusCode(Response::HTTP_CONFLICT);
        }

        return response()
            ->json([
                'error' => "Group `${id}` not found",
            ])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
    }
    public function join(Request $request) {

        $group_user = new Group_user();
        $group_user->user_id = $request->input('user_id');
        $group_user->group_id = $request->input('group_id');
        $group_user->save();

        return $group_user;
    }
}
