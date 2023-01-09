<?php
/******************************************************
 * Flashcard script
 * Version : {version}
 * Copyright© 2016 Avrasys Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:https://flashcardscript.com
 ******************************************************/
?>
@extends('layouts.back')
@section('content')
        <section class="content">

          <h1>
            {!! trans('flashcard.profileSettings') !!}
          </h1>
          @include('common.errors')
    	  <form id="profileForm" role="form" method="post" action="{{ Config::get('RELATIVE_URL') }}/profile" encType="multipart/form-data">
    	  {{ csrf_field() }}
       	  <div class="row">
       	  	<div class="col-md-6">
			   <h2 class="page-header">{!! trans('flashcard.changeUsername') !!}</h2>
               <div class="form-group">
                 <input type="text" class="form-control" id="username" name="username" style="max-width:300px;" value="{{Sentinel::getUser()->username}}">
               </div>
			   <h2 class="page-header">{!! trans('flashcard.changeEmailAddress') !!}</h2>
               <div class="form-group">
                 <label>{!! trans('flashcard.currentEmail') !!}:  {{Sentinel::getUser()->email}}</label><br>
                 <label for="exampleInputPassword1">{!! trans('flashcard.newEmailAddress') !!}</label>
                 <input type="email" class="form-control" name="email" id="email" style="max-width:300px;">
               </div>
               <div class="form-group">
                 <label for="exampleInputPassword1">{!! trans('flashcard.confirmNewEmailAddress') !!}</label>
                 <input type="email" class="form-control" name="emailConfirm" id="emailConfirm" style="max-width:300px;">
               </div>
			   <h2 class="page-header">{!! trans('flashcard.changeAdminPassword') !!}</h2>
               <div class="form-group">
                 <label for="exampleInputPassword1">{!! trans('flashcard.currentPassword') !!}</label>
                 <input type="password" class="form-control" id="currentPassword" name="currentPassword" style="max-width:300px;">
               </div>
               <div class="form-group">
                 <label for="exampleInputPassword1">{!! trans('flashcard.newPassword') !!}</label>
                 <input type="password" class="form-control" id="password" name="password" style="max-width:300px;">
               </div>
               <div class="form-group">
                 <label for="exampleInputPassword1">{!! trans('flashcard.confirmNewPassword') !!}</label>
                 <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" style="max-width:300px;">
               </div>
       	  	</div>
       	  	<div class="col-md-6">
			   <h2 class="page-header">{!! trans('flashcard.changeAvatar') !!}</h2>
               <div class="form-group">
                 <div class="user-block">
                    <img id="photoImage" src="@if (Sentinel::getUser()->photo == null) {{ Config::get('RELATIVE_URL') }}/public/images/no-image.jpg @else {{ Config::get('RELATIVE_URL') }}/public/{{Sentinel::getUser()->photo}} @endif" alt="User Avatar" style="width:60px;height:60px;margin:5px 20px 5px 0;">
                    <span><button class="btn btn-default btn-lg" style="margin-bottom:5px;opacity:0.5;" onclick="chooseFile();return false;"><i class="fa fa-cloud-upload"></i>&nbsp;&nbsp; {!! trans('flashcard.upload') !!}</button>&nbsp;&nbsp;</span>
                    <span class="description">{!! trans('flashcard.msg3') !!}</span>
                    <div style="display:none"><input type="file" name="photoImageFile" accept="image/*"></div>
                  </div>
               </div>
       	  	</div>
       	  </div>
       	  <div>
               <button type="submit" class="btn btn-success">{!! trans('flashcard.save') !!}</button>
       	  </div>
          </form>
        </section>
<script type="text/javascript">
function chooseFile() {
	$("input[name='photoImageFile']").change(function(e){
		$("#photoImage").attr("src", URL.createObjectURL(e.target.files[0]));
	});
	$("input[name='photoImageFile']").click();
}

$(function(){
	$("#profileForm").submit(function(){
		
		if($("#email").val() != "" && $("#email").val() != $("#emailConfirm").val()) {
			alert("{!! trans('flashcard.msg4') !!}");
			return false;
		}
		
		if($("#password").val() != "" && $("#password").val() != $("#passwordConfirm").val()) {
			alert("{!! trans('flashcard.msg5') !!}");
			return false;
		}

		if($("#currentPassword").val() == "") {
			alert("{!! trans('flashcard.msg7') !!}");
			$("#currentPassword").focus();
			return false;
		}

		$("#profileForm").submit();
	});
});
</script>
@endsection
