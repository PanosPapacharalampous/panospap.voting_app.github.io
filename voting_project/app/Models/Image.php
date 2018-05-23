<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	// sinithos otan exoume pivot table einai belongsToMany to relationship, dimiourgoume relation metaksy tou model category kai tou image, apo mono tou tha anagnwrisei ta antistoixa id's.
	
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category','categories_images');
    }

    // to relationship metaksy tou model images (pivot table) kai tou model users 

    public function users()
    {
        return $this->belongsToMany('App\User','users_images');
    }
}