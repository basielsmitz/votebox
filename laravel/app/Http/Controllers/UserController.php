<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
                    $users = User::orderBy('id','asc')->paginate(10);
                    $users->withPath('users?keyword=all');

                }break;


                default : {
                    $users = User::SearchByKeyword($keyword)->paginate(10);
                    $users->withPath('users?keyword=' . strtolower($keyword));
                }
            }
        }
        else
        {
            $users = User::orderBy('id','asc')->paginate(10);
            $users->withPath('users?keyword=all');

        }

        return view('users', compact('users'));


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $user = User::find($id) ;
        $age = User::getAge($user->birthdate);
        $groups = User::find($id)->groups;


        return view('detail.user', compact('user','age','groups'));
//        return $groups;
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
        //
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
    }
}
