<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller{

    public function newCategory()
    {
        // thelw na dw, an yparxoun hdh 4 kathgories kataxwrhmenes apo auton to xrhsth
        $user = Auth::user();
        $admin = $user->is_admin; // is_admin einai to neo column ston pinaka users pou pernei times true/false (1/0) analogos me to an einai o user admin i oxi
        $count = Category::where('user_id',$user->id)->count(); //metra sto model category opou to user_id (to column tou category) einai iso me tou auth::user() to id dld tou logarrismenou xrhsth an einai panw apo 4..
        if($count >= 4 && !$admin){
            session()->flash('msg','You can\'t post more than 4 categories. Sorry!');
            session()->flash('status','warning');
            return redirect('/');
        }

        return view('add_category'); //fortwse to view add_catefory
    }


    public function addCategory(Request $request)
    {
        //elegxw an exei postarei hdh 4 cathgories
        $user = Auth::user();
        $admin = $user->is_admin;
        $count = Category::where('user_id',$user->id)->count();
        if($count >= 4 && !$admin){
            session()->flash('msg','You can\'t post more than 4 categories. Sorry!');
            session()->flash('status','warning');
            return redirect('/');
        }

        $title = $request->input('title'); //pare san ipnut to'title'name of specific field-column in form
        $category = new Category(); // Dimiourgise kainourgeio model Category 
        $category->title = $title; // vale sto column 'title' to input me name title pou pires apo tin forma
        $category->user_id = Auth::user()->id; //stin thesi user_id (column tou model) vale to id tou loggarismenou xrhsth
        $category->save(); // kane save ta data pou perastikan
        session()->flash('msg','Your category has been saved.'); // to session exei dimiourgithei sto app.blade
        session()->flash('status','success');
        return redirect('/'); //redirect sto homepage
    }

    public function editCategory($category_id) //otan mpei sto url to path enos category me '/id' (tou category) tha treksei auto to function kai tha parei to category id pou tou stalthike apo to view
    {
        $category = Category::find($category_id); //vres kai vale stin metavliti $category opou sto model category to 'category_id' einai iso me to $category_id pou exeis parei

        // thelw na dw, an h kathgoria auth einai kataxwrhmenh apo ton idio xristi pou epixeirh na tin epeksergastei, h an einai admin o xristis
        $user = Auth::user();
        $admin = $user->is_admin;
        if($category->user_id == $user->id || $admin){
            return view('edit_category',['category' => $category]); // pigaine sto edit_category view kai steile mazi kai to $category

        }
        session()->flash('msg','You can\'t edit this category!');
        session()->flash('status','warning');
        return redirect('/');

    }


    public function updateCategory(Request $request) //pernei to request apo to edit_category view
    {
        $user = Auth::user();
        $admin = $user->is_admin;
        $category = Category::find($request->input('category_id')); //vres apo to category model to category me input to category_id pou pires apo to post
        if($category->user_id == $user->id || $admin){ // ama einai o idios user h' admin
            $category->title = $request->input('title'); //perna stin thesi title tou model to input title pou pires
            $category->save(); //kane save
            return redirect('/'); //redirect sto home page
            $msg = 'Category #'.$category->id.'has been updated';
            $status = 'success';
        }

        $msg = 'You do not have permission to edit this category';
        $status = 'warning';
        session()->flash('msg', $msg);
        session()->flash('status', $status);

    }

    public function deleteCategory($categoryid) // pernei to id tis sigkekrimenis katigorias, exei dimiourgithei sto route na treksei deleteCategory/id (id=$categoryid tou function)
    {
        if(Auth::user()->is_admin) { //ama einai admin o logarismenos xristis, diladi epistrepsei true (an einai 1)
//            find simainei where id =...
            $category = Category::find($categoryid); //vres apo to model category tin catigoria me id = $categoryid
            $msg = 'Category "' . $category->title . '" has been deleted successfully!';
            $status = 'success';
            $category->delete(); // kanei delete tin catigoria (des function delete sto model category)
        }else{
            $msg = 'Only admins can delete categories!';
            $status = 'warning';
        }
        session()->flash('msg', $msg);
        session()->flash('status', $status);
        return redirect('/');
    }
}
