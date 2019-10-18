<?php

namespace App\Models;

use App\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Election extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_elections')->withPivot('score', 'id', 'approved');
    }

    /**
     * @param $query
     * @param $keyword
     * @return mixed
     *
     * return query from keyword search in db
     */
    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword != '') {
            $query->where(function ($query) use ($keyword) {
                $query->where("name", "LIKE", "%$keyword%")
                    ->orWhere("description", "LIKE", "%$keyword%");
            });
        }
        return $query;
    }

    /**
     * @param $query
     *
     * retrun all open elections with candidates and set satus as open
     */
    public function scopeWhereOpenInit($query)
    {
        $open = $query
            ->with('candidates')
            ->where('startDate', '<', Carbon::now())
            ->where('endDate', '>', Carbon::now());

        foreach ($open->get() as $election) {
            $election->isClosed = false;
            $election->save();

        }
    }

    /**
     * @param $query
     * @return mixed
     *
     * get all open elections and set open if status was closed
     */
    public function scopeWhereOpen($query)
    {
        $open = $query
            ->with('candidates')
            ->where('startDate', '<', Carbon::now())
            ->where('endDate', '>', Carbon::now());

        foreach ($open->get() as $election) {
            $original = $election->isClosed;
            if($original){
                $election->isClosed = false;
                $election->save();
            }

        }
        return $open;
    }


    /**
     * @param $query
     * @return mixed
     *
     * get all closed elections, set status to closed and calculate candidate scores
     */
    public function scopeWhereClosedInit($query)
    {
        $closed = $query
            ->with('candidates')
            ->where('endDate', '<', Carbon::now());

        foreach ($closed->get() as $election) {
            $election->isClosed = true;
            $election->save();
            $candidates = $election->candidates;

            foreach ($candidates as $candidate){
                $score = Vote::where('CandidateElection_id','=',$candidate->pivot->id)->count();

                //replace the old score
                $canEl = Candidate_election::find($candidate->pivot->id);
                $canEl->score = $score;
                $canEl->save();
            }

        }
        return $closed;

    }

    /**
     * @param $query
     * @return mixed
     *
     * get all candidates where start date is in future and set statuses
     */
    public function scopeComing($query){
        $coming = $query->with('candidates')->where('startDate', '>', Carbon::now());
        foreach ($coming->get() as $election) {
            $election->isClosed = true;
            $election->isComing = true;
            $election->save();
        }
        return $coming;
    }

    /**
     * @param $query
     * @return mixed
     *
     * return all closed elections set and calculate scores if status wasn't closed already
     */
    public function scopeWhereClosed($query)
    {
        $closed = $query
            ->with('candidates')
            ->where('endDate', '<', Carbon::now());


        foreach ($closed->get() as $election) {
            $original = $election->isClosed;
            if(!$original){
                $election->isClosed = true;
                $election->save();
                $candidates = $election->candidates;

                foreach ($candidates as $candidate){
                    $score = Vote::where('CandidateElection_id','=',$candidate->pivot->id)->count();

                    //replace the old score
                    $canEl = Candidate_election::find($candidate->pivot->id);
                    $canEl->score = $score;
                    $canEl->save();
                }
            }
        }
        return $closed;

    }

}