<?php
/******************************************************
 * Flashcard script
 * Version : {version}
 * Copyright© 2016 Avrasys Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:https://flashcardscript.com
 ******************************************************/
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ Config::get('SITE_TITLE') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/css/main.css?_={{time()}}">
    <link rel="stylesheet" href="{{ Config::get('RELATIVE_URL') }}/public/css/sl-slide.css">

    <script src="{{ Config::get('RELATIVE_URL') }}/public/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	<script src="{{ Config::get('RELATIVE_URL') }}/public/js/jquery/jQuery-2.1.4.min.js"></script>
	<script src="{{ Config::get('RELATIVE_URL') }}/public/js/bootstrap.min.js"></script>
<script>
var random = {{$exercise->randomWord}};
var relationURL = "{{ Config::get('RELATIVE_URL') }}";
var settings = <?php echo json_encode($settings) ?>;
var exercise = <?php echo json_encode($exercise) ?>;
</script>
<script src="{{ Config::get('RELATIVE_URL') }}/public/js/main.js"></script>
</head>
<body>
	    <div class="container">	
    		<div class="flashcard-box">
    			<div class="center title-desc">
    				<label>{!! trans('flashcard.clickFlashCard') !!}</label>
    			</div>
    			<div class="content">
    				<div class="content-header">
    					<div style="display:inline-block;float:left;height:100%;position:relative">
	    					<select class="form-control sel-category classic pull-left" onchange="selectCategory(this.value)">
		                        <option value="">{!! trans('flashcard.selectCategory') !!}</option>
		                        @foreach ($cats as $cat)
									<option value="{{$cat->id}}">{{$cat->category}}&nbsp;({{$cat->count}})</option>
								@endforeach
		                    </select>
		                    <i class="glyphicon glyphicon-chevron-down select-down" aria-hidden="true"></i>
    					</div>
    					<div>
    						<label class="status-text"></label>
    					</div>
    				</div>
    				<div class="content-header-border"></div>
    				<div class="content-main">
    					<div style="display:inline-block;" id="flashCard-container">
    						<div style="float:left;display:inline-block;width:100%;padding-right:40px;">
    							<div class="flip-container" id="flip-toggle">
									<div class="flipper">
										<div class="front">
			    							<div class="flashcard" onclick="$('.flip-container').addClass('flip');"></div>
										</div>
										<div class="back" >
			    							<div class="flashcard" onclick="$('.flip-container').removeClass('flip');"></div>
										</div>
									</div>
								</div>
    						</div>
    						<div class="audio" onclick="playAudio();" style="margin-left:-30px">
    							<span class="fa fa-volume-up fa-2x"></span>
    							<audio id="audioFile" style="display:none" controls>{!! trans('flashcard.audioNotSupported') !!}</audio>
    						</div>
    					</div>
						<div class="subscribe-container">
							<div class="subscribe-header">
								<div class="row">
									<div class="col-xs-3 col-sm-4 text-center">
										<img src="{{ Config::get('RELATIVE_URL') }}/public/images/subscribe-icon.png" style="margin-top:5px;max-width:100%;">
									</div>
									<div class="col-xs-9 col-sm-8">
										<div class="title-text">{!! trans('flashcard.subscribeToNewsl') !!}</div>
										<p>{!! trans('flashcard.subscribeToNewslDesc') !!}</p>
									</div>
								</div>
							</div>
							<div class="subscribe-footer">
								<div class="row" id="subscribe-step1">
									<div class="col-xs-6 col-sm-7" style="padding:0">
										<input type="text" class="form-control" placeholder="Email" id="email" style="min-height:30px">
									</div>
									<div class="col-xs-6 col-sm-5" style="padding-right:0">
										<button class="btn btn-block btn-subscribe" onclick="subscribe()"><span class="glyphicon glyphicon-refresh spinning"></span>&nbsp;{!! trans('flashcard.subscribeBtn') !!}</button>
									</div>
								</div>
								<div class="row" id="subscribe-step2" style="display:none">
									<div class="col-xs-12 col-md-12 text-center" style="color:white;font-size: 20px;">
										{!! trans('flashcard.subscribeThanks') !!}
									</div>
								</div>
							</div>
						</div>
						<div class="ad-container"></div>
    				</div>
    			</div>
			    <div class="bottom">
			    	<div style="display:inline-block;">
			    		<button class="btn btn-success btn-lg" onclick="goPrev();"><img src="{{ Config::get('RELATIVE_URL') }}/public/images/prev.png">&nbsp;&nbsp;&nbsp;{!! trans('flashcard.prev') !!}</button>&nbsp;&nbsp;&nbsp;
			    		<button class="btn btn-success btn-lg" onclick="restart();">{!! trans('flashcard.restart') !!}</button>&nbsp;&nbsp;&nbsp;
			    		<button class="btn btn-success btn-lg" onclick="goNext();">{!! trans('flashcard.next') !!}&nbsp;&nbsp;&nbsp;<img src="{{ Config::get('RELATIVE_URL') }}/public/images/next.png"></button>
			    	</div>
			    </div>
				<div class="ad-container-bottom"></div>
    		</div>
    	</div>
</body>
</html>