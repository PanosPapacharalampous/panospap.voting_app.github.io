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
        <div class="panel-heading">ADD NEW TEG AWARDS CATEGORY</div>
        <div class="panel-body">
        <!-- forma me methodo post tha treksei apo to CategoriesController to function addCategory  -->
            <form method="POST" action="{{action('CategoriesController@addCategory')}}">
                <label for="title">Title</label>
                <input type="text" id="title" name="title">

                <input type="submit" value="Save">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
@endsection