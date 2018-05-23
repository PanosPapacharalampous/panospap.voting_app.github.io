<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Vote;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allcategories = Category::all(); //apothikeuse san $allcategories ola ta data apo to model category
        $users = User::all(); //apothikeuse san $users ola ta data apo to model user
        $userVoteCount = Vote::where('voter_id',Auth::user()->id)->count(); //metra kai apothikeuse san $userVoteCount osa sto 'voter_id' exoun to id tou loggarismenou xrhsth
        $isAdmin = Auth::user()->is_admin; //$isAdmin einai iso me osa o loggarismenos xrhsths einai isos me to column is_admin, dld 1 (true)

        return view('home',['categories'=>$allcategories , 'users' => $users , 'userVoteCount' => $userVoteCount , 'isAdmin' => $isAdmin]);
        // steile sto home oles tis metavlites pou exoume orisei me ta antistoixa onomata..
    }
    public function contestants()
    {
        $users = User::all();
        $isAdmin = Auth::user()->is_admin;
        $allcategories = Category::all();
       
     

        return view('contestants',['users' => $users,'isAdmin'=> $isAdmin, 'categories'=>$allcategories]);
    }


}