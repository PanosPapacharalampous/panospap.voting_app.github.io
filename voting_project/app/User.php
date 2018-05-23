<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function images()
    {
        return $this->belongsToMany('App\Models\Image','users_images');
    }

    public function profileImage()
    {   
        // profile_image_id einai column tou model users
        if(empty($this->profile_image_id)){
            if($this->images()->count() > 0){
                $img = $this->images()->first();
                $path = $img->path;
            }else{
                $path = asset('img/default-user.png');
            }
        }else{
            $img = App\Models\Image::find($this->profile_image_id);
            $path = $img->path;
        }

        return $path;

    }
}
