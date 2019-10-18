<?php

namespace App\Http\Controllers\API;

use App\Models\Party;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Party::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "Party can only be made in the backoffice";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $party = Party::
            with('candidates')
            ->with('candidates.user')
            ->find($id);

        return $party ?: response()
            ->json([
                'error' => "Party `${id}` not found",
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
        $party = Party::find($id);

        //check input from request and change in the table if needed
        if($request->input('name') == null || $party->name == $request->input('name') ||
            $request->input('name') == '')
        {
            $party->name = $party->name;
        } else {
            $party->name = $request->input('name');
        }

        if($request->input('description') == null || $party->description == $request->input('description') ||
            $request->input('description') == '')
        {
            $party->description = $party->description;
        } else {
            $party->description = $request->input('description');
        }

        $party->save();

        return 'Party with id ' . $party->id . ' updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $party = Party::find($id);

        if ($party) {
            if ($party->delete()) {
                return response()
                    ->json($party)
                    ->setStatusCode(Response::HTTP_OK);
            }

            return response()
                ->json([
                    'error' => "Party `${id}` could not be deleted",
                ])
                ->setStatusCode(Response::HTTP_CONFLICT);
        }

        return response()
            ->json([
                'error' => "Party `${id}` not found",
            ])
            ->setStatusCode(Response::HTTP_NOT_FOUND);
    }
}
