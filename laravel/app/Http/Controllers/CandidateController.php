<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate_election;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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

    public function approve($election, $candidate) {

        $candidateElection = Candidate_election::where('candidate_id', $candidate)
            ->where('election_id', $election)->first();
        $candidateElection->approved = true;
        $candidateElection->save();

        return redirect('/backoffice/elections/'.$election);
    }
    public function unapprove($election, $candidate) {

        $candidateElection = Candidate_election::where('candidate_id', $candidate)
            ->where('election_id', $election)->first();
        $candidateElection->approved = false;
        $candidateElection->save();

        return redirect('/backoffice/elections/'.$election);
    }
}
