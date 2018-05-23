@extends('layouts.app')

@section('title')Contestants
@endsection

@section('content')

	@foreach($users as $user)

	<div class="user panel panel-default">
            <div class="panel-heading">
                <h2 class="user-title">{{$user->name}}</h2>

                </div>
                <div class="user-toolbar">
                    {{--is admin einai dilwmeno ston controllerhome, class add image sto button to xrisimopoioume gia to js-click function--}}
                    <span class="btn btn-sm btn-default addImage"><i class="glyphicon glyphicon-camera"></i></span>

                    
                </div>
           

            <div class= "panel body">
            	 <form class="image-upload dropzone" action="{{action('ImagesController@saveImage')}}">
                
                <input type="hidden" name="user_id" value="{{$user->id}}">
                
                {{ csrf_field() }}
            	
            	</form>
           
            	
            </div>


	
	 @if($user->images()->count()>0)
            <div class="images">
                {{--$user->images() is relationship functions from model user with model Image | calling it as a function with () returns Query --}}
                @if($user->images()->count() == 1)
                    {{--asset: returns URL-link starting from public folder--}}
                <img class="contestants" src="{{asset($user->images()->first()->path)}}">
                @else
                <div id="user-images-{{$user->id}}" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        {{-- $user->images is like calling $user->images()->get() = Collection --}}
                        <!-- $i=>$img, key=>value einai kanonas tis php gia foreach sxeseis -->
                        @foreach($user->images as $i=>$img)
                        <li data-target="#user-images-{{$user->id}}" data-slide-to="{{$i}}"></li>
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @foreach($user->images()->orderBy('created_at','desc')->get() as $img)
                        <div class="item">
                            <img src="{{asset($img->path)}}">
                        </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#user-images-{{$user->id}}" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#user-images-{{$user->id}}" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                @endif
             </div>
        @endif
        	
        	<div class="well">
        	
        	<p> You have collected {{App\Models\Vote::where('user_id',$user->id)->count()}} votes </p>

        	<p> You have voted {{App\Models\Vote::where('voter_id',$user->id)->count()}} times</p>

        	
    	
        	
        	

        	


        	

        	

        	
        	</div>
 	</div>
     @endforeach

@endsection

@section('extrascripts')
<script>
$(document).ready(function(){

 $('.addImage').click(function(){
//            ama einai active kai kaneis click kane hide, allios kane show

            if($(this).hasClass('active')){
                $(this).removeClass('active')
                $(this).parents('.user').find('.image-upload').hide()
            }else{
                $(this).addClass('active')
                $(this).parents('.user').find('.image-upload').show()
            }

        })

 $(".image-upload").each(function(){

            $(this).dropzone({
                url: "{{action('ImagesController@saveImage')}}",
                acceptedFiles: "image/*",
                maxFilesize: 3,
                paramName: 'image'
            });
        });
       $('.carousel').find('.carousel-indicators li:first-child').addClass('active')
        $('.carousel').find('.carousel-inner .item:first-child').addClass('active')
})

</script>

@endsection