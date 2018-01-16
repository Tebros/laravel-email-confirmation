<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConfirmation extends Model
{
    protected $table = 'users_confirmation';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
