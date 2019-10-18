<?php

namespace App\Http\Controllers\API;

use App\Models\History;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use DB;
use CreateVotesTable;
use Ramsey\Uuid\Uuid;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Vote::all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request;

        $vote = new Vote();
        // Create Universally Unique Identifier.
        do {
            //uuid4 creates a random uuid.
            $uuid = Uuid::uuid4()->toString(); // @see https://github.com/ramsey/uuid
        } while (DB::table(CreateVotesTable::TABLE)
            ->select(CreateVotesTable::PK)
            ->where(CreateVotesTable::PK, $uuid)
            ->exists());
        $vote->uuid = $uuid;


        $vote->checksum = $request->input('checksum');
        $vote->voteType = $request->input('voteType');
//        $vote->agreed = intval($request->input('agreed'));
//        $vote->referendum_id = $request->input('referendum_id');
//        $vote->CandidateElection_id = $request->input('CandidateElection_id');


        if(intval($vote->voteTye) === 0)
        {
            $vote->agreed = null;
            $vote->referendum_id = null;
            $vote->CandidateElection_id = $request->input('CandidateElection_id');

        } else {
            $vote->agreed = intval($request->input('agreed'));
            $vote->referendum_id = $request->input('referendum_id');
            $vote->CandidateElection_id = null;

        }

        // Create Checksum, assume password
        $data = $vote->getAttributes();
        ksort($data);

        $value = hash('sha512', (json_encode($data)).$vote->checksum);
        // \Log::debug([$data, $value]);
        $vote->checksum = $value;
//        dd($history);

        $vote->save();
        $history = new History();
        $history->user_id = $request->input('user_id');
        $history->election_id = $request->input('election_id');
        $history->referendum_id = $request->input('referendum_id');
        $history->save();


//        $object = (object) [
//            'all' => $data,
//            'open' => $history,
//        ];
//        return response()->json($object);
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        return "votes can not be edited";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "votes can not be deleted";
    }
}
