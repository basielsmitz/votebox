<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Group;
use App\Models\Votemanager;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ElectionController extends Controller
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
                    $elections = Election::WhereOpen()->latest()->paginate(10);
                    $elections->withPath('elections?keyword=open');

                }break;
                case 'coming':{
                    $elections = Election::Coming()->latest()->paginate(10);
                    $elections->withPath('elections?keyword=coming');

                }break;
                case 'all':{
                    $elections = Election::latest()->paginate(10);
                    $elections->withPath('elections?keyword=all');

                }break;
                case 'closed':{
                    $elections = Election::WhereClosed()->latest()->paginate(10);
                    $elections->withPath('elections?keyword=closed');

                }break;

                default : {
                    $elections = Election::SearchByKeyword($keyword)->latest()->paginate(10);
                    $elections->withPath('elections?keyword=' . strtolower($keyword));
                }
            }
        }
        else
        {
            $elections = Election::latest()->paginate(10);
            $elections->withPath('elections?keyword=all');

        }


        return view('elections', compact('elections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        $datetime = Carbon::now()->addDay(1);
        $end = Carbon::now()->addMonth();

        return view('crud.createElection', compact('groups', 'datetime', 'end'));

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
        $startTime = strtotime(request('startDate'). " " .request('startTime'));
        if( $startTime <= $time){
            $closed = false;
        }

        $this->validate(request(), [
            'name' => 'required',
            'description' => 'required',
            'startDate' => 'required|date|after_or_equal:tomorrow' ,
            'startTime' => 'required',
            'endDate' => 'required|date|after_or_equal:startDate',
            'endTime' => 'required',
            'group' => 'required',
            'pictureUri' => 'image'

        ]);




        //TODO votemanager_id = huidige votemanger


        $election = New Election();
        $election->name = request('name');
        $election->description = request('description');
        $election->startDate = request('startDate') . " " .request('startTime');
        $election->endDate = request('endDate') . " " . request('endTime');
        $election->group_id = request('group');
        $election->isClosed = true;
        $election->isComing = true;
        $election->votemanager_id = 1;
        $election->pictureUri = "";
        $election->save();
        if($request->hasFile('imgUpload'))
        {
            $request->file('imgUpload')->storeAs('election-images', 'election'.$election->id.'.jpg');
        }
        $election->pictureUri = url('/').'/storage/election-images/election'.$election->id.'.jpg';
        $election->save();
        return redirect('/backoffice/elections');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $election = Election::with('candidates.user')->with('candidates.party')->find($id);
        $group = Group::find($election->group_id);
        $votemanager = Votemanager::find($election->votemanager_id);
        $unapproved = [];

        foreach ($election->candidates as $candidate){
            if(!$candidate->pivot->approved){
                array_push($unapproved, $candidate);
            };

        }

        return view('detail.election', compact('election','group','votemanager', 'unapproved'));
//        return $results;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $election = Election::with('candidates.user')->with('candidates.party')->find($id);
        $group = Group::find($election->group_id);
        $groups = Group::all();
        return view('crud.editElection', compact('election',  'group', 'groups'));
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
            'name' => 'required',
            'description' => 'required',
            'startDate' => 'required|date',
            'startTime' => 'required',
            'endDate' => 'required|date|after_or_equal:startDate',
            'endTime' => 'required',
            'group' => 'required',
            'pictureUri' => 'image'
        ]);
        $startTime = strtotime(request('startDate'). " " .request('startTime'));
        if( $startTime <= $time){
            $closed = false;
        }

        if($request->hasFile('imgUpload'))
        {
            $request->file('imgUpload')->storeAs('election-images', 'election'.$id.'.jpg');
        }


        //TODO votemanager_id = huidige votemanger remove candidate_id
        Election::find($id)->update([
            'name' => request('name'),
            'description' => request('description'),
            'startDate' => request('startDate') . " " .request('startTime'),
            'endDate' => request('endDate') . " " . request('endTime'),
            'group_id' => request('group'),
            'isClosed' => $closed,
            'isComing' => true,
            'votemanager_id' => 1,
            'pictureUri' => url('/').'/storage/election-images/election'.$id.'.jpg'
        ]);
        return redirect('/backoffice/elections/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $election= Election::findOrFail($id);
        $election->delete();
        return redirect('/backoffice/elections/');
    }
}
