<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }

    public function images()
    {
        return $this->belongsToMany('App\Models\Image','categories_images');
            //'categories_images','category_id','image_id'
    }

    public function delete()
    {
//  trexei prwta to fucntion delete pou tha svisei category me to sygkekrimeno id
// apo to model votes kai meta to parent(delete-tou model) pou svinei to antistoixo category apo to model category
        $this->votes()->delete();
        /* 1os tropos gia delete images
        //kanoume get tis sysxetizomenes eikones
        $images = $this->images;
        //svhnw tis eggrafes apo ton pivot pinaka
        $this->images()->sync([]);
        //kai meta svhnw 1-1 tis eikones pou pira prin
        foreach($images as $img){
            $img->delete();
        }
        */
        /* 2os tropos gia delete images*/
        //to pluck fernei to column pou tou zitas apo to query kai to all() ta kanei array
        $imageids = $this->images()->pluck('id')->all();
        //svhnw tis eggrafes apo ton pivot pinaka - na diavasw attach/detach/sync relationships
        $this->images()->sync([]);
        //sto sygkekrimeno model svise (destroy)...(svinei apo ton pinaka image)
        Image::destroy($imageids);

        parent::delete();
    }
}