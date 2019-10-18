<?php

namespace App\Http\Controllers;

use App\Models\Referendum;
use App\Models\Group;
use App\Models\Votemanager;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReferendumController extends Controller
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
                case 'open':{
                    $referenda = Referendum::WhereOpen()->latest()->paginate(10);
                    $referenda->withPath('referenda?keyword=open');

                }break;
                case 'all':{
                    $referenda = Referendum::orderBy('id','asc')->latest()->paginate(10);
                    $referenda->withPath('referenda?keyword=all');

                }break;
                case 'closed':{
                    $referenda = Referendum::WhereClosed()->latest()->paginate(10);
                    $referenda->withPath('referenda?keyword=closed');

                }break;
                case 'published':{
                    $referenda = Referendum::WherePublished()->latest()->paginate(10);
                    $referenda->withPath('referenda?keyword=published');


                }break;
                case 'unpublished':{
                    $referenda = Referendum::WhereUnpublished()->latest()->paginate(10);
                    $referenda->withPath('referenda?keyword=unpublished');

                }break;
                default : {
                    $referenda = Referendum::SearchByKeyword($keyword)->latest()->paginate(10);
                    $referenda->withPath('referenda?keyword=' . strtolower($keyword));
                }
            }
        }
        else
        {
            $referenda = Referendum::latest()->paginate(10);
            $referenda->withPath('referenda?keyword=all');

        }
        return view('referenda', compact('referenda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        $datetime = Carbon::now();
        $end = Carbon::now()->addMonth();
        return view('crud.createReferendum', compact('groups', 'datetime', 'end'));
//        return $datetime;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $closed = true;
        $time = strtotime(Carbon::now());

        $this->validate(request(), [
        'title' => 'required',
        'description' => 'required',
//        'startDate' => 'required|date' ,
        'startDate' => 'required|date|after_or_equal:yesterday' ,
        'startTime' => 'required',
        'endDate' => 'required|date|after_or_equal:startDate',
        'endTime' => 'required',
        'group' => 'required',
    ]);
        $startTime = strtotime(request('startDate'). " " .request('startTime'));
        if( $startTime <= $time){
            $closed = false;
        }

        //TODO votemanager_id = huidige votemanger remove candidate_id
        Referendum::create([
            'title' => request('title'),
            'description' => request('description'),
            'startDate' => request('startDate') . " " .request('startTime'),
            'endDate' => request('endDate') . " " . request('endTime'),
            'group_id' => request('group'),
            'isClosed' => $closed,
            'votemanager_id' => 1,
            'candidate_id' => 1,
            'published' => Carbon::now(),
        ]);
        return redirect('/backoffice/referenda');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $referendum = Referendum::with('votes')->find($id);
        $agree = count(Referendum::with(['votes' => function($query) {
            $query->where('agreed', true);
        }])->find($id)->votes);
        $disagree = count(Referendum::with(['votes' => function($query) {
            $query->where('agreed', false);
        }])->find($id)->votes);
        $total = $agree + $disagree;
        $group = Group::find($referendum->group_id);
        $votemanager = Votemanager::find($referendum->votemanager_id);

//        return $agree;
        return view('detail.referendum', compact('referendum', 'agree', 'disagree', 'total', 'group', 'votemanager'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $referendum = Referendum::with('votes')->find($id);
        $group = Group::find($referendum->group_id);
        $groups = Group::all();
        return view('crud.editReferendum', compact('referendum',  'group', 'groups'));
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
//        dd(request()->all());
        $closed = true;
        $time = strtotime(Carbon::now());

        $this->validate(request(), [
            'title' => 'required',
            'description' => 'required',
            'startDate' => 'required|date',
            'startTime' => 'required',
            'endDate' => 'required|date|after_or_equal:startDate',
            'endTime' => 'required',
            'group' => 'required',
        ]);
        $startTime = strtotime(request('startDate'). " " .request('startTime'));
        if( $startTime <= $time){
            $closed = false;
        }
        if(request('published')){
            $published = Carbon::now();
        }
        else{
            $published = null;
        }

        //TODO votemanager_id = huidige votemanger remove candidate_id
        Referendum::find($id)->update([
            'title' => request('title'),
            'description' => request('description'),
            'startDate' => request('startDate') . " " .request('startTime'),
            'endDate' => request('endDate') . " " . request('endTime'),
            'group_id' => request('group'),
            'isClosed' => $closed,
            'votemanager_id' => 1,
            'candidate_id' => 1,
            'published' => $published,
        ]);
        return redirect('/backoffice/referenda/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $referendum = Referendum::findOrFail($id);
        $referendum->delete();
        return redirect('/backoffice/referenda');
    }
}
