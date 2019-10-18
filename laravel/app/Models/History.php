<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{


    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    



}
