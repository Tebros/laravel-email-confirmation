<?php

namespace Tebros\EmailConfirmation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EMailConfirmation extends Model
{

    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'email_confirmation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
