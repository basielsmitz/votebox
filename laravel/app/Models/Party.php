<?php

namespace App\Models;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Party extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
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
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("name", "LIKE","%$keyword%")
                    ->orWhere("description", "LIKE", "%$keyword%");
            });
        }
        return $query;
    }
}
