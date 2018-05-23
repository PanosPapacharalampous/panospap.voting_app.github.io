<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// elegxei an einai logarismenos o xristis meso tou middleware allios den trexei tin arxiki selida dld apo ton homecontroller to function index
Route::group(['middleware' => 'auth'], function () {
    Route::get('/',  'HomeController@index'); 
    Route::get('contestants', 'HomeController@contestants');
    Route::get('new-category', 'CategoriesController@newCategory'); // me url new-category trexei apo ton controller CategoriesController to function newCategory
    Route::post('add-category', 'CategoriesController@addCategory');
    Route::get('votes', 'VotesController@votes');
    Route::post('add-vote', 'VotesController@addVote');
    Route::post('change-vote', 'VotesController@changeVote');
    Route::get('delete-category/{id}','CategoriesController@deleteCategory'); //sto url delete-category/id trexei apo ton controller categoriesController to function deleteCategory kai pernei mazi kai to sygkekrimeno id gia na to xrisimopoieisei sto sigkekrimeno function
    Route::get('edit-category/{id}', 'CategoriesController@editCategory');
    Route::post('update-category', 'CategoriesController@updateCategory');
    Route::post('save-image', 'ImagesController@saveImage');

});

Route::get('test',function(){

        $v= App\Models\Vote::first();
        dd($v);


$a = App\Models\Category::find(1);

$a->images;
dd($a);


});

Route::auth();
