<?php

namespace App\Http\Controllers;


use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ImagesController extends Controller{

    public function saveImage(Request $request)
    {

        //pairnei tin eikona kai tin swzei me tin katallhlh sxesh
        // arxika checkarw an yparxei sto request input me type="file" kai name="image"
        if($request->hasFile('image')) {
            $file = $request->file('image');

            //edw kanw save to file me to random name pou eftiakse h PHP kai to arxiko extension opws to esteile o client
            //
            // $filename = $file->getFilename().'.'.$file->getClientOriginalExtension();
            $filename = str_replace('.tmp','',$file->getFilename()).'.'.$file->getClientOriginalExtension();

            $file->move('images',$filename);
            
            // ftiaxnw ena model Image
            $img = new Image();
            $img->path = 'images/'.$filename; // sto column path apothikeufse to sigkekrimeno path
            $img->user_id = Auth::user()->id;
            $img->save();

            //Kai meta kanw to swsto relationship (user_id kai category_id, apo ta pivot tables pou exw dimiourgisei)
            if($request->has('user_id')){
                $id = $request->input('user_id');
                //  attach - inserts related model when working with many to many relations, inserting a record in the intermediate table, tha valei to id tou user_id gia to antistoixo image / detach will remove the record from the intermediate table.
                $img->users()->attach($id);
            }
            if($request->has('category_id')){
                $id = $request->input('category_id');
                
                $img->categories()->attach($id);
            }
            // Afou xrhsimopoioume to dropzone, pou stelnei ta images me AJAX, den prepei na steilw kapoio redirect pisw, alla apla ena OK h ena JSON.
            return response()->json(['message'=>'Your image has been saved']);
        }else{
            return response()->json(['error'=>'No file has been selected'],500);
        }



    }
}