<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;


class Vote extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function option()
    {
        return $this->hasOne('App\User');
    }

    public function voter()
    {
        return $this->belongsTo('App\User','voter_id');
    }

    public function sendMail()
    {
        Mail::send($this->voter->email,'You have voted for "'.$this->option->name.'" in category "'.$this->category->title.'"');
    }
}
