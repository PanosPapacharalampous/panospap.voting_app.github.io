<?php

namespace App\Http\Controllers;


use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class VotesController extends Controller{

    public function votes()
    {
        return view('votes'); //fwrtwse to view votes
    }


    public function addVote(Request $request) //pare to request apo to form sto home.blade
    {
        $userid = $request->input('userid'); //pare san  input to userid (name) apo tin forma
        $categoryid = $request->input('categoryid'); //pare to categoryid (san name) apo tin forma
        if(empty($userid) || empty($categoryid)){ 
            // ama einai empty (dld null), to empty einai idio me to isset
            $msg = 'Something went wrong!';
            $status = 'error';
            session()->flash('msg',$msg); // flash is used for temporary session **ONLY 1 REQUEST**, exei dimiourgithei sto app.blade to session kai to warning
            session()->flash('status',$status);
            return redirect()->back();
        }
        $voter = Auth::user(); //$voter einai iso me to model tou logarismenou xrhsth (einai o logarismenos xrhstis)

        if($voter->id == $userid){
            // elexw an o logarismenos xrhsths paei na psifisei ton eauto tou, an to id tou xrhsth pou paei na psifisei einai iso me to id tou xrhsth pou psifise (userid)
            $msg = 'You can\'t vote yourself!';
            $status = 'warning';
        }else{
            $vote = new Vote(); // anoikse kainourgeio Vote model

            $vote->user_id = $userid; //perna stin thesi user_id to $userid pou pires
            $vote->voter_id = $voter->id; //perna stin thesi voter_id tou logarismenou xrhsth to id
            $vote->category_id = $categoryid; //kai stin thesi category_id to $categoryid pou pires apo to request

            $vote->save(); //kane save 
            $msg = 'Your vote has been saved.';
            $status = 'success';
//            
        }
        session()->flash('msg',$msg); // flash is used for temporary session **ONLY 1 REQUEST**
        session()->flash('status',$status);
        return redirect()->back(); //refresh the page
    }

    public function changeVote(Request $request)
//        Ajax request from javascript
    {
        $userid = $request->input('userid');
        $categoryid = $request->input('categoryid');

        $vote = Vote::where('category_id',$categoryid)->where('voter_id',Auth::user()->id)->first(); //fere apo to vote model to prwto pou tha vreis me 'category_id' = $categoryid kai 'voter_id' = tou logarismenou to id
        $status = 'warning';
        if(Auth::user()->id == $userid){
            $msg = 'You can\'t vote yourself you selfish prick!';
        }else{

            if($vote->user_id == $userid){ //ama sto apotelesma apo to vote model to column user_id einai iso me $userdi apo to request tote..
                $msg = 'You have already voted for this person.';
            }else{
                $vote->user_id = $userid; //vale stin thesi 'user_id' to userid apo to request dld ton kainourgeio user pou psifise
                $vote->save(); //kane save
                $msg = 'Your vote has been changed';
                $status= 'success';
            }
        }

        session()->flash('msg',$msg);
        session()->flash('status',$status);
        return response()->json(['msg'=>$msg]);

    }
}
