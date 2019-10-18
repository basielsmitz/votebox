<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $keyword = $request->input('keyword');

        if ($keyword != '') {


            switch (strtolower($keyword)){
                case 'all':{
                    $groups = Group::latest()->paginate(10);
                    $groups->withPath('groups?keyword=all');

                }break;


                default : {
                    $groups = Group::SearchByKeyword($keyword)->latest()->paginate(10);
                    $groups->withPath('groups?keyword=' . strtolower($keyword));
                }
            }
        }
        else
        {
            $groups = Group::latest()->paginate(10);
            $groups->withPath('groups?keyword=all');

        }

        return view('groups', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crud.createGroup');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'description' => 'required',
            'pictureUri' => 'image'

        ]);


        $group = New Group();
        $group->name = request('name');
        $group->description = request('description');
        $group->pictureUri = "";
        $group->save();
        if($request->hasFile('imgUpload'))
        {
            $request->file('imgUpload')->storeAs('group-images', 'group'.$group->id.'.jpg');
        }
        $group->pictureUri = url('/').'/storage/group-images/group'.$group->id.'.jpg';
        $group->save();
        return redirect('/backoffice/groups');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::with('users')->find($id);
//        $users = User::with('groups')->find($id);
//        $users = $group->getPaginatedUsers();
        $users = $group->users()->paginate(10);

        return view('detail.group', compact('group', 'users'));
//        return count($users);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);

        return view('crud.editGroup', compact('group'));
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
        $this->validate(request(), [
            'name' => 'required',
            'description' => 'required',
            'pictureUri' => 'image'
        ]);

        if($request->hasFile('imgUpload'))
        {
            $request->file('imgUpload')->storeAs('group-images', 'group'.$id.'.jpg');
        }

        Group::find($id)->update([
            'name' => request('name'),
            'description' => request('description'),
            'pictureUri' => url('/').'/storage/group-images/group'.$id.'.jpg'
        ]);
        return redirect('/backoffice/groups/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return redirect('/backoffice/groups');
    }
}
