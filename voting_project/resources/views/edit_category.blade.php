@extends('layouts.app')

@section('title')Voting Buddy
@endsection

@section('extrastyles')
    <style>
        h2{
            font-size: 36px;
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">EDIT CATEGORY</div>
        <div class="panel-body">

            <form method="POST" action="{{action('CategoriesController@updateCategory')}}"> 
                <label for="title">Title</label>
                <!-- pernei san value tou title kai tou category_id oti exei stalei apo to function editcategory sto CategoriesController pou exei stalei san $category -->
                <input type="text" id="title" name="title" value="{{$category->title}}" > 
                <input type="hidden" name="category_id" value="{{$category->id}}"> 
                <input type="submit" value="Save">
                {{ csrf_field() }}
            </form>

        </div>
    </div>
@endsection

