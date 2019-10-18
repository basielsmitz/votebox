<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{

    protected $primaryKey = 'uuid';
    /**
     * @var array
     */
    protected $fillable = [
        'voteType', 'agreed', 'referendum_id', 'CandidateElection_id', 'checksum'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Relates a Vote with a Referendum
     */
    public function referendum()
    {
        return $this->belongsTo(Referendum::class);
    }

    /**
     * @var array
     * allow everything
     */
    protected $guarded = [];

}