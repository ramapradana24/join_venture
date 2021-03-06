@extends('layouts.app2')

@section('title')
JoinVenture - Home
@endsection

@section('story')
active
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.fancybox.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/line-awesome.min.css') }}">

<style type="text/css">
    .bg-light{
        background-color: #f1ecec!important;
    }

	.img-preview{
		max-height: 100px;
		margin-right: 2px; 
	}

	.imagelist > a > img{
		max-height: 100px;	
	}

	/*style tambahan*/

    .post > .dropdown-toggle::after{
        display: none;
    }
    
    .card-timeline-title {
        border-top-left-radius: 0px;
        border-top-right-radius: 25px;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 25px;
        margin-top: 120px;
    }
    .image-home {
        max-height: 110px;
        border-top-right-radius: 15px;
        border-top-left-radius: 15px;
        object-fit: cover;
    }
    .image-profile {
        width: 80px; 
        height: 80px;
        margin-top: 70px;
        margin-left: 15px; 
        border: 2px solid;
        border-color: #FFFFFF;
        object-fit: cover;
    }
    .image-timeline {
        max-height: 300px;
        border-top-right-radius: 15px;
        border-top-left-radius: 15px;
        object-fit: cover;
        opacity: 0.5;
    }
    .image-story {
        width: 60px;
        height: 60px;
        display: inline-block;
        cursor: pointer;
    }
    .image-story:hover {
        opacity: 0.6;
        transition: 0.5s;
    }
    .image-arrow {
        width: 20px;
        opacity: 0.6;
        display: block;
        margin: 0 auto;
        cursor: pointer;
    }
    .image-arrow:hover {
        opacity: 0.2;
        transition: 0.4s;
    }
    .image-upload > input {
    	display: none;
    }
    .image-upload > label:hover{
        opacity: 0.5;
        transition: 0.5s;
    }
    .vertical-scroll-wrapper {
        width: 100%;
        height: 180px;
        overflow-y: auto;
        overflow-x: hidden;         
    }
    #horizontal-scroll-wrapper {
        height:60px;
        background-color: #FFF;
        overflow-x: auto;
        overflow-y: hidden;
        border-radius: 50px;
        white-space: nowrap;
        scroll-behavior: smooth;
    }
    #horizontal-scroll-wrapper::-webkit-scrollbar {
        display: none;
    }

    @media (max-width: 575px) {
        #leftArrow {
            display: none;
        }
        #rightArrow {
            display: none;
        }
    }

    .action-icon > span{
        margin-left: 5px;
        margin-bottom: 0px;
    }

    .card-body{
        padding-bottom: 5px !important;
    }
</style>
<script type="text/javascript" async>
	function getPostImage(post_id){
		var url = '/post/image/' + post_id;
		var div_class = 'imagelist' + post_id;
		$.ajax({
			type:'get',
			url:url,
			success:function(data){
				$('#' + div_class).html(data);
			},
			error: function(){
				// alert('gagal');
			}
		})
	}

	function loadComment(post_id){
		var url = 'api/comment/' + post_id;

		$.ajax({
			type:'get',
			url:url,
			success: function(data){
				$('#comments'+post_id).html(data);
			},
			error: function(){
				// alert("error collecting comment");
			}
		});
	}

    function getLike(post_id){
        var url = '/post/like/' + post_id + '/count';
        $.ajax({
            type:'get',
            url:url,
            success: function(data){
                if(data['user_like'] == 0 && data['like_count'] > 0){
                    $('#like'+post_id).html(data['like_count'] + ' orang menyukai ini');
                }else if(data['user_like'] > 0 && data['like_count'] > 0){
                    $('#like'+post_id).html('anda dan ' + data['like_count'] + ' orang lain menyukai ini');
                }
                else if(data['user_like'] == 1){
                    $('#like'+post_id).html('anda menyukai ini');
                }else if(data['like_count'] > 0){
                    $('#like'+post_id).html(data['like_count'] + ' orang menyukai ini');
                }else{
                    $('#like'+post_id).html('');
                }
            },
            error: function(){
                // alert('error like');
            }
        })
    }
</script>
@endsection

@section('section')
<div class="container" style="margin-top: 80px;">
    <div class="row">   
        <div class="col-md-4 col-sm-12">
            <div class="card card-rounded">
                <img style="position: relative;" class="image-home" src="/img/users/{{ Auth::user()->img_home }}"> 
                <div style="position: absolute;">
                    <img class="rounded-circle image-profile" src="img/users/{{ Auth::user()->img_profile }}" style="background-color: #CCC">
                </div>
                <div style="position: absolute;">
                    <div style="width: 250px; margin-left: 120px; margin-top: 100px;">
                        <div class="green-text">
                            <br>
                            <h5><b>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</b></h5>
                            <small class="color-text">"Living Like Larry"</small>                       
                        </div>
                    </div>
                    
                </div>
                <br>
                <div class="card-body">
                    <br>
                    <br>
                    <div class="row">
                        {{-- Stories --}}
                        <div class="col-3 px-0 text-center grey-text">
                            <div>
                                <a href=""><small><b>Stories</b></small></a>
                            </div>
                            <div>
                                <small class="grey-text">{{count($post)}}</small>
                            </div>
                        </div>

                        {{-- Followers --}}
                        <div class="col-3 px-0 text-center grey-text">
                            <div>
                                <a href="" data-toggle="modal" data-target="#followersModal"><small><b>Pengikut</b></small></a>
                            </div>
                            <div>
                                <small class="grey-textt">{{count($followers)}}</small>
                            </div>
                            <div class="modal fade" id="followersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Pengikut</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left vertical-scroll-wrapper">
                                        @if(count($followers) > 0)
                                            @foreach($followers as $follower)
                                                <div class="row">
                                                    <div class="col-8">
                                                        <a href=""><h6>{{ $follower->first_name." ".$follower->last_name }}</h6></a>
                                                    </div>
                                                    <div class="col-4">
                                                        {{-- <button class="btn buttonRounded pull-right" type="button">Follow</button> --}}
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        @else
                                            <h6>Belum ada orang yang mengikuti</h6>
                                        @endif
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Following --}}
                        <div class="col-3 px-0 text-center grey-text">
                            <div>
                                <a href="" data-toggle="modal" data-target="#followingModal"><small><b>Mengikuti</b></small></a>
                            </div>
                            <div>
                                <small class="grey-text">{{count($following)}}</small>
                            </div>
                            <div class="modal fade" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Mengikuti</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left vertical-scroll-wrapper">
                                        @if(count($following) > 0)
                                            @foreach($following as $following)
                                                <div class="row">
                                                    <div class="col-8">
                                                        <a href=""><h6>{{ $following->first_name." ".$following->last_name }}</h6></a>
                                                    </div>
                                                    <div class="col-4">
                                                        {{-- <button class="btn buttonRounded pull-right" type="button">Unfollow</button> --}}
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        @else
                                            <h6>Belum ada orang yang diikuti</h6>
                                        @endif
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Adventure --}}
                        <div class="col-3 px-0 text-center grey-text">
                            <div>
                                <a href="" data-toggle="modal" data-target="#adventureModal"><small><b>Petualangan</b></small></a>
                            </div>
                            <div>
                                <small class="grey-text">{{count($user_adventure)}}</small>
                            </div>
                            <div class="modal fade" id="adventureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Petualanganmu</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left vertical-scroll-wrapper">
                                        @if(count($user_adventure) > 0)
                                            @foreach($user_adventure as $adventure)
                                                <div>
                                                    <a href="{{ route('adventure.show', $adventure->id) }}">{{ $adventure->adventure_name }}</a>
                                                </div>
                                                <hr>
                                            @endforeach
                                        @else
                                            <div>
                                                <p>Belum ada petualangan yang diikuti</p>   
                                            </div>
                                        @endif
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="green-text">
                        <br>
                        <div class="text-right">
                            <a href="{{ route('profile')}}"><i class="fa fa-cog" aria-hidden="true" style="font-size: 2.5em; width: 20px;"></i></a>
                        </div>                       
                    </div>
                </div>
            </div>
            <div class="card card-rounded my-2">
                <div class="card-body">
                    <div class="green-text">
                        <h5><b>Top Stories</b></h5>
                        <br>
                        <div class="row">
                            <div id="leftArrow" class="col-md-1 col-sm-1 px-0 pt-4">
                                <img src="{{asset('img/left-arrow.png')}}" class="image-arrow">
                            </div>
                            <div class="col-md-10 col-sm-10">
                                <div id="horizontal-scroll-wrapper">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-1.jpg')}}">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-2.jpg')}}">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-1.jpg')}}">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-2.jpg')}}">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-1.jpg')}}">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-2.jpg')}}">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-1.jpg')}}">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-2.jpg')}}">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-1.jpg')}}">
                                    <img class="image-story rounded-circle" src="{{asset('img/nearby-2.jpg')}}">
                                </div>
                            </div>
                            <div id="rightArrow" class="col-md-1 col-sm-1 px-0 pt-4">
                                <img src="{{asset('img/right-arrow.png')}}" class="image-arrow">
                            </div>
                            
                        </div>
                        
                        <br>
                        <h5><b>Petualanganmu</b></h5>
                        <hr>
                        <div class="vertical-scroll-wrapper">
                            @if(count($user_adventure) > 0)
                                @foreach($user_adventure as $adventure)
                                    <div>
                                        <a href="{{ route('adventure.show', $adventure->id) }}">{{ $adventure->adventure_name }}</a>
                                    </div>
                                    <hr>
                                @endforeach
                            @else
                                <div>
                                    <p>Belum ada petualangan yang diikuti</p>   
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="card card-rounded">
            	<form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
	        		@csrf
	        		<div class="card-body">
                        <div class="form-group">
                            <textarea class="form-control bg-light card-rounded" name="description" id="post" rows="3" placeholder="Where have you been, {{Auth::user()->first_name}}?" required></textarea>
                        </div>
	                    <div id="previewImage"></div>
	                </div>
                    <div class="col-sm-12">
                    	<div class="image-upload">
                    		<label for="image-input">
                    			<img class="mx-2" src="{{asset('img/choose-image.png')}}" style="max-width: 30px; opacity: 0.6; cursor: pointer;">
                    		</label>
                         	<input type="file" name="image_post[]" id="image-input" multiple="" accept="image/*">
                        	<button type="submit" class="btn buttonRounded pull-right px-md-4 px-sm-1 mx-2">PUSH</button>
                   		</div>
                    </div>
            	</form>               
            </div>
            <br>

           
            @foreach($user_friend_post as $post)
                @if($post->status==1)
                	<div class="card mb-2 card-rounded">
    	                <div class="card-body">
                            {{-- post --}}
                            <div class="dropdown d-flex justify-content-end post">
                                @if(Auth::user()->id == $post->user_id)
                                    <a href="" class="dropdown-toggle" data-toggle="dropdown" style="color: #000;"><i style="font-size: 1.2em;" class="fa fa-ellipsis-h grey-text" aria-hidden="true"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route( 'post.edit', $post->id) }}" data-toggle="modal" data-target="#editModal{{$post->id}}">Edit</a>
                                        <form action="{{ route('post.destroy', $post->id) }}" method="post">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button class="dropdown-item" type="submit">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            {{-- Modal Edit Post --}}
                            <form action="{{ route('post.update', $post->id) }}" method="post" class="modal fade" id="editModal{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Post</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <div class="modal-body">
                                    <div class="form-group">
                                        <textarea class="form-control bg-light card-rounded" name="description" required>{{$post->description}}</textarea>
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn buttonRounded btn-outline-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn buttonRounded">Simpan</button>
                                    </div>
                                    </div>
                                </div>
                            </form>

                            <h5 class="green-text" style="font-weight: bold; margin-bottom: 0px;">{{ $post->first_name." ".$post->last_name}}</h5>
                            @php
                                $time = new App\Http\Controllers\TimeForHumans; 
                            @endphp
                            <p style="margin-top: 0; font-size: 11px;" class="color-text-o">{{ $time->time_elapsed_string($post->created_at) }}<p>
                            <div style="font-size: 14px;" class="color-text">
                                {!! $post->description !!}  
                            </div>
                            <script type="text/javascript">
                                getPostImage({{ $post->id }});
                            </script>
                            <div class="imagelist" id="imagelist{{ $post->id }}">
                                {{-- ajax --}}
                            </div>

                            {{-- comment and like icon --}}
                            <div style="margin-top: 30px;" class="action-icon">
                                <span class="color-text fa fa-comment-o" id="comment-icon{{ $post->id }}" onclick="toggle_comment({{ $post->id }})" style="cursor: pointer;"></span>
                                <span class="color-text fa {{ $post->status_like == 1 ? ' fa-thumbs-up' : 'fa-thumbs-o-up'}}" id="like-icon{{ $post->id }}" onclick="like({{ $post->id }})" style="cursor: pointer;"></span>
                                <span id="like{{ $post->id }}" class="color-text"></span>
                                <script type="text/javascript">
                                    window.setInterval(function(){
                                        loadComment({{ $post->id }})
                                    }, 5000);
                                </script>    
                            </div>  
                            {{-- post --}}
    	                </div>
    	                <div class="card-footer bg-light">
    	                    <div class="row" id="toggle-comment{{ $post->id }}" style="display: none;">
                        		<div class="col-sm-11">
                        			<input id="comment{{ $post->id }}" type="text" name="comment" class="form-control" placeholder="komentar disini.." style="border-style: none;">
                        		</div>
                        		<div class="col-sm-1">
                                    <span class="la la-paper-plane color-text pull-right" style="font-size: 35px; cursor: pointer;" onclick="sendComment({{ $post->id.",".Auth::user()->id }})"></span>
                        		</div>
    	                    </div>

    	                  	<div class="row col-sm-12" style="padding-top: 20px;" id="comments{{ $post->id }}">
    	                  		
    	                  	</div>
    	                </div>
    	            </div>
                    <script type="text/javascript">
                        getLike({{ $post->id }});
                    </script>
                @endif
            @endforeach()
         
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/jquery.fancybox.min.js') }}" async defer></script>
<script type="text/javascript" src="{{ asset('js/general.js') }}" async defer></script>
<script type="text/javascript" async>

	function previewImage(input){
		if(input){
			var i = 0;
			for(i ; i < input.files.length; i++){
				var reader = new FileReader();

				reader.onload = function(e){
					var image = "<img class='img-preview' src='"+ e.target.result +"' alt='your image' />";
					$('#previewImage').append(image);
				}

				reader.readAsDataURL(input.files[i]);
			}
		}
	}

	$("#image-input").change(function() {
		$('#previewImage').html('');
		previewImage(this);
	});

	function sendComment(post_id, user_id){
		var url = '/api/comment/store';
		var comment = $('#comment' + post_id).val();
		var params = "?comment=" + comment + "&post_id=" + post_id + "&user_id=" + user_id;
		var fullUrl = url + params;
		$('#comment' + post_id).val('');
		$.ajax({
			type:'get',
			url:fullUrl,
			success: function(data){
				loadComment(post_id);
			},
			error: function(){
				// alert('error saving comment');
			}
		});
	}

    function like(post_id){
        var url = 'like/' + post_id;
        $.ajax({
            type:'get',
            url:url,
            success: function(){
                var class_name = $('#like-icon' + post_id).attr('class');
                if(class_name == 'color-text fa fa-thumbs-o-up'){
                    $('#like-icon' + post_id).attr('class', 'color-text fa fa-thumbs-up');
                }else{
                    $('#like-icon' + post_id).attr('class', 'color-text fa fa-thumbs-o-up');
                }
                getLike(post_id);
            }
        })
    }

	document.addEventListener('DOMContentLoaded', function () {   
        var buttonRight = document.getElementById('rightArrow');
        buttonRight.onclick = function () {
            document.getElementById('horizontal-scroll-wrapper').scrollLeft += 64;
        };
        var buttonLeft = document.getElementById('leftArrow');
        buttonLeft.onclick = function () {
            document.getElementById('horizontal-scroll-wrapper').scrollLeft -= 64;
        };
    }, false);	

</script>
@endsection