<?php

namespace App;

use App\Models\{
    History, Post, Voter, Candidate, Group
};
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'firstname', 'lastname', 'gender', 'birthdate', 'email', 'password', 'lastLogin', 'pictureUri', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'lastLogin',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Relates a user with a voter
     */
    public function voter()
    {
        return $this->belongsTo(Voter::class, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Relates a user with a candidate
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * Relates a user with posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * relates a user with history
     */
    public function history() {
        return $this->hasMany(History::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * Relates a User with Groups
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_users');
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
                $query->where("firstname", "LIKE","%$keyword%")
                    ->orWhere("lastname", "LIKE", "%$keyword%")
                    ->orWhere("email", "LIKE", "%$keyword%")
                    ->orWhere("gender", "=", "$keyword")
                    ->orWhere("username", "LIKE", "%$keyword%")
                    ->orWhere("birthdate", "LIKE", "%$keyword%");
            });
        }
        return $query;
    }

    /**
     * @param $birthDate
     * @return int
     *
     * return age from brithdate
     */
    public static function getAge($birthDate) {
        $birthDate = explode("-", $birthDate);
        $currentDate = explode("-", date('Y-m-d'));
        $age = 0;
        if($birthDate[1]<$currentDate[1]){

            $age = $currentDate[0]-$birthDate[0];
        }
        elseif ($birthDate[1]==$currentDate[1]){
            if($birthDate[2]<=$currentDate[2]){
                $age = $currentDate[0]-$birthDate[0];
            }
            else $age =$currentDate[0]-$birthDate[0]-1;
        }
        else{
            if($birthDate[2]<=$currentDate[2]){
                $age = $currentDate[0]-$birthDate[0];
            }
            else $age =$currentDate[0]-$birthDate[0]-1;
        }
        return $age;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * get user registrations data
     */
    public static function getRegisteredMonth(){
        return User::select(\DB::raw('count(id) as `total`'),
                            \DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupby('year','month')
            ->get();
    }
}
