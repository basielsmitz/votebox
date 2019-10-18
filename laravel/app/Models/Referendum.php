<?php

namespace App\Models;

use App\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referendum extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Relates a Referendum with a Candidate
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Relates a Referendum with a Votemanager
     */
    public function votemanager()
    {
        return $this->belongsTo(Votemanager::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Relates a Referendum with a Group
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Relates a Referendum with Votes
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * @param $query
     * @param $keyword
     * @return mixed
     * return query from keyword search in db

     */
    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("title", "LIKE","%$keyword%")
                    ->orWhere("description", "LIKE", "%$keyword%");
            });
        }
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     *
     * return all open referenda and set their status to open if they were closed
     */
    public function scopeWhereOpen($query){
        $open = $query
            ->where('startDate', '<', Carbon::now())
            ->where('endDate', '>', Carbon::now());

        foreach ($open->get() as $referendum) {
            if($referendum->isClosed){
                $referendum->isClosed = false;
                $referendum->save();
            }
        }
        return $open;
    }

    /**
     * @param $query
     * @return mixed
     *
     * return all open referenda and set their status to open
     */
    public function scopeWhereOpenInit($query){
        $open = $query
            ->where('startDate', '<', Carbon::now())
            ->where('endDate', '>', Carbon::now());

        foreach ($open->get() as $referendum) {
            $referendum->isClosed = false;
            $referendum->save();

        }
        return $open;
    }

    /**
     * @param $query
     * @return mixed
     *
     * return all closed referenda and set their status to closed if it was open
     */
    public function scopeWhereClosed($query){
        $closed = $query
            ->where('endDate', '<', Carbon::now());

        foreach ($closed->get() as $referendum) {
            if(!$referendum->isClosed){
                $referendum->isClosed = true;
                $referendum->save();
            }
        }
        return $closed;
    }

    /**
     * @param $query
     * @return mixed
     *
     * return all closed referenda and set their status to closed
     */
    public function scopeWhereClosedInit($query){
        $closed = $query
            ->where('endDate', '<', Carbon::now());

        foreach ($closed->get() as $referendum) {
            $referendum->isClosed = true;
            $referendum->save();
        }
        return $closed;
    }

    /**
     * @param $query
     * @return mixed
     * return all published referenda
     */
    public function scopeWherePublished($query){
        return $query->whereNotNull('published');
    }

    /**
     * @param $query
     * @return mixed
     * return all unpublished referenda
     */
    public function scopeWhereUnpublished($query){
        return $query->whereNull('published');
    }
}