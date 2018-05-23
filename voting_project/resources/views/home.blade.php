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

    <!-- foreach gia na paroume kathe row xwrista tou model category -->
        @foreach($categories as $category) 
        <div class="category panel panel-default">
        <!-- emfanise to title tou kathe category -->
            <div class="panel-heading">
                <h2 class="category-title">{{$category->title}}</h2>
                <div class="category-toolbar">
                    {{--is admin einai dilwmeno ston controllerhome--}}
                    <span class="btn btn-sm btn-default addImage"><i class="glyphicon glyphicon-camera"></i></span>
                    <!-- ama o loggarismenos xrhsths einai admin h' stin sigkekrimeni katigoria to user_id einai iso me to id tou loggarismenou xrhsth, dld einai autos pou exei ftiaksei tin katigoria tote.. -->
                    @if($isAdmin || $category->user_id == Auth::user()->id)
                        <a href="{{action('CategoriesController@editCategory',$category->id)}}"><span class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i></span></a>
                    @endif
                    @if($isAdmin)
                        <a href="{{action('CategoriesController@deleteCategory',$category->id)}}"><span class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></span></a>
                    @endif
                </div>
            </div>
            <div class="panel-body">

            <!-- pote dimiourgithike i kathe katigoria -->
            <p class="posted">Posted on {{$category->created_at}}</p>

            <!-- ftiaxnw to form gia to image, me type file kai name image -->

            <form class="image-upload dropzone" id="image-upload-form-{{$category->id}}" action="{{action('ImagesController@saveImage')}}">
                <div class="fallback">
                    <input name="image" type="file"/>
                </div>
                <input type="hidden" name="category_id" value="{{$category->id}}">
                {{ csrf_field() }}
            </form>
            @if($category->images()->count()>0)
            <div class="images">
                {{--$category->images() is relationship functions from model Category with model Image | calling it as a function with () returns Query --}}
                @if($category->images()->count() == 1)
                    {{--asset: returns URL starting from public folder--}}
                <img src="{{asset($category->images()->first()->path)}}">
                @else
                <div id="category-images-{{$category->id}}" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        {{-- $category->images is like calling $category->images()->get() = Collection --}}
                        <!-- $i=>$img, key=>value einai kanonas tis php gia foreach sxeseis -->
                        @foreach($category->images as $i=>$img)
                        <li data-target="#category-images-{{$category->id}}" data-slide-to="{{$i}}"></li>
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @foreach($category->images()->orderBy('created_at','desc')->get() as $img)
                        <div class="item">
                            <img src="{{asset($img->path)}}">
                        </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#category-images-{{$category->id}}" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#category-images-{{$category->id}}" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                @endif
                </div>
            @endif
            {{-- PSAXNO AN EXEI PSHFISEI O LOGGARISMENOS XRHSTHS GIA TIN SYGEKRIMENH KATIGORIA--}}
            @if($category->votes()->where('voter_id',Auth::user()->id)->count() > 0)
                <p class="results">RESULTS</p>
                @foreach($users as $user)
                    {{--o logarismenos xristis poion psifise--}}
                    <?php $myVote = $category->votes()->where('voter_id',Auth::user()->id)->where('user_id',$user->id)->count();
                        $classname = ($myVote > 0)?'btn-primary':'btn-success';
                    ?>
                    {{--PSAXNO POSOUS PSIFOUS EXEI O SYGEKRIMENOS XRISTHS - oxi o loggarismenos, GIA THN SYGEKRIMENH KATIGORIA kai pernaw kai tin metavliti classname gia na allazoun ta koumpia xrwma analogos me ton poion exei psifisei--}}
                    <span class="btn {{$classname}} vote-button" data-userid="{{$user->id}}" data-categoryid="{{$category->id}}">
                            <img class="profile-image" src="{{$user->profileImage()}}">
                        
                    {{$user->name}} - {{$category->votes()->where('user_id',$user->id)->count()}}</span>
                    {{--category_id = column--}}
                @endforeach
            @else
                <p class="vote">VOTE</p>
                @foreach($users as $user)
               
                   <form class="voting-form" method="POST" action="{{action('VotesController@addVote')}}" >
                    <!-- postare to name tou user -->
                        <input type="submit" value="{{$user->name}}">
                        <!-- to id tou user gia name = userid -->
                        <input type="hidden" name="userid" value="{{$user->id}}">
                        <!-- to id tis categorias gia name = categoryid -->
                        <input type="hidden" name="categoryid" value="{{$category->id}}">

                        {{ csrf_field() }}
                        
                    </form>
                   
                @endforeach
            @endif
            </div>
        </div>
        @endforeach

<div class="votes-stats panel panel-default">
    <div class="panel-heading">My Total Votes</div>
    <div class="panel-body">
        {{-- AN EISAI ADMIN PESTO!, to isAdmin einai dilomeno ston homeController--}}
        @if($isAdmin) 
        <p>You are an admin!</p>
        @else
        <p>You are a simple Tegger</p>
        @endif
        {{-- PSAXNO POSES PSIFOUS EXEI RIKSEI - poses fores exei psifisei- SYNOLIKA O LOGGARISMENOS XRHSTHS, to userVoteCount einai dilwmeno sto home controller --}}
        <p>You have voted {{$userVoteCount}} times</p>
        {{-- PSAXNO POSES PSIFOUS EXEI PAREI SYNOLIKA O LOGGARISMENOS XRHSTHS --}}
        <p>You have been voted {{App\Models\Vote::where('user_id',Auth::user()->id)->count()}} times</p>
    </div>
</div>

@endsection


@section('extrascripts')
<script>
    $(document).ready(function(){
        $('.vote-button').click(function(){

            var kostas = $(this).data('userid'); //   apo to data-userid tou class vote-button
            var categoryid = $(this).data('categoryid'); //apo to data-categoryid tou class vote-button,
            var dataForServer = {
                userid: kostas, // ,to userid einai auto pou kanw request sto votescontroller/changevote
                categoryid: categoryid, // to categoryid einai idio me to request sto votesconroller/changevote
                _token: '' // anti gia csrf_field(), xrisimopoiw auto gia to java script
            }
            var ajaxOptions = {
                type: "POST",
                url: "{{action('VotesController@changeVote')}}",
                data: dataForServer,
                success: function(result){
                    window.location.reload() // reload the page
                }
            };

            $.ajax(ajaxOptions);
        })

        $('.addImage').click(function(){
//            ama einai active kai kaneis click kane hide, allios kane show

            if($(this).hasClass('active')){
                $(this).removeClass('active')
                $(this).parents('.category').find('.image-upload').hide()
            }else{
                $(this).addClass('active')
                $(this).parents('.category').find('.image-upload').show()
            }

        })

        $('.carousel').find('.carousel-indicators li:first-child').addClass('active')
        $('.carousel').find('.carousel-inner .item:first-child').addClass('active')

        //dropzone
        $(".image-upload").each(function(){

            $(this).dropzone({
                url: "{{action('ImagesController@saveImage')}}",
                acceptedFiles: "image/*",
                maxFilesize: 3,
                paramName: 'image'
            });
        });
    })

</script>
@endsection
