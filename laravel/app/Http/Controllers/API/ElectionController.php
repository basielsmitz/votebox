<?php

namespace App\Http\Controllers\API;

use App\Models\Election;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Election::all();
        $open = Election::WhereOpen()->get();
        $closed = Election::WhereClosed()->get();

        $object = (object) [
            'all' => $all,
            'open' => $open,
            'closed' => $closed,
        ];
        return response()->json($object);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "Election can only be made in the backoffice";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $election = Election::
            with('candidates')
            ->with('candidates.user')
            ->with('candidates.party')
            ->find($id);

        return $election ?: response()
            ->json([
                'error' => "Election `${id}` not found",
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
        $election = Election::find($id);

        //check input from request and change in the table if needed
        if($request->input('name') == null || $election->name == $request->input('name') ||
            $request->input('name') == '')
        {
            $election->name = $election->name;
        } else {
            $election->name = $request->input('name');
        }

        if($request->input('description') == null || $election->description == $request->input('description') ||
            $request->input('description') == '')
        {
            $election->description = $election->description;
        } else {
            $election->description = $request->input('description');
        }

        if($request->input('startDate') == null || $election->startDate == $request->input('startDate') ||
            $request->input('startDate') == '')
        {
            $election->startDate = $election->startDate;
        } else {
            $election->startDate = $request->input('startDate');
        }

        if($request->input('endDate') == null || $election->endDate == $request->input('endDate') ||
            $request->input('endDate') == '')
        {
            $election->endDate = $election->endDate;
        } else {
            $election->endDate = $request->input('endDate');
        }

        if($request->input('isClosed') == null || $election->isClosed == $request->input('isClosed') ||
            $request->input('isClosed') == '')
        {
            $election->isClosed = $election->isClosed;
        } else {
            $election->isClosed = $request->input('isClosed');
        }

        $election->save();

        return 'Election with id ' . $election->id . ' updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $election = Election::find($id);

        if ($election) {
            if ($election->delete()) {
                return response()
                    ->json($election)
                    ->setStatusCode(Response::HTTP_OK);
            }

            return response()
                ->json([
                    'error' => "Election `${id}` could not be deleted",
                ])
                ->setStatusCode(Response::HTTP_CONFLICT);
        }

        return response()
            ->json([
                'error' => "Election `${id}` not found",
            ])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
    }
}
