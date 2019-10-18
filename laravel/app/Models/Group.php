<?php

namespace App\Models;

use App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Group extends Model
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
     *
     * Relates a Group with Referendums
     */
    public function referendums()
    {
        return $this->hasMany(Referendum::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * Relates a Group with Users
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Relates a Group with Posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
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
    public function getPaginatedUsers(){
        return $this->users()->paginate(10);
    }

}
