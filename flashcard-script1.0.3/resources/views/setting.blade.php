<?php
/******************************************************
 * Flashcard script
 * Version : 1.0.3
 * Copyright© 2016 Avrasys Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:https://flashcardscript.com
 ******************************************************/
?>

@extends('layouts.back')
@section('content')
	<section class="content">

		<h1>
			{!! trans('flashcard.generalSettings') !!}
		</h1>
		@include('common.errors')
		<form id="langForm" role="form" method="post" action="{{ Config::get('RELATIVE_URL') }}/setting">
			{{ csrf_field() }}

			<div class="row">
				<div class="col-md-8">
					<div class="form-group" style="padding-top:30px;">
						<label for="siteTitle" class="pull-left" style="font-size:16px;width:250px;margin-top:-5px">
							{!! trans('flashcard.siteTitle') !!}<br>
							<span style="font-size:12px;font-weight:normal;font-style: italic">{!! trans('flashcard.siteTitleDesc') !!}</span>
						</label>
						<input type="text" class="form-control pull-left" id="siteTitle" name="siteTitle" value="{{ Config::get('SITE_TITLE') }}" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group" style="padding-top:20px;">
						<label for="siteTitle" class="pull-left" style="font-size:16px;width:250px;margin-top:-5px">
							{!! trans('flashcard.changeLanguage') !!}<br>
							<span style="font-size:12px;font-weight:normal;font-style: italic">{!! trans('flashcard.changeLanguageDesc') !!}</span>
						</label>
						<select name="lang" class="form-control bfh-languages" data-language="{{App::getLocale()}}" data-available="{{$langStr}}" data-blank=false style="max-width:300px;"></select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<h2 style="color:#009688">{!! trans('flashcard.adSettings') !!}</h2>
					<hr style="margin-top: 10px;border-color: #9BBDD1;">
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<label for="siteTitle" style="font-size:16px;">
						{!! trans('flashcard.inlineAdSpot') !!}<br>
						<span style="font-size:12px;font-weight:normal;font-style: italic">
							{!! trans('flashcard.msg8') !!}
						</span>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<textarea style="width:600px;height:150px" name="inlineAdSpot" placeholder="{!! trans('flashcard.msg14') !!}">{{isset($settings['inlineAdSpot'])?$settings["inlineAdSpot"]:''}}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<label for="siteTitle" style="font-size:16px;">
						{!! trans('flashcard.adSpotBelowExercise') !!}<br>
						<span style="font-size:12px;font-weight:normal;font-style: italic">
							{!! trans('flashcard.msg9') !!}
						</span>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<textarea style="width:600px;height:150px" name="belowAdSpot" placeholder="{!! trans('flashcard.msg15') !!}">{{isset($settings['belowAdSpot'])?$settings["belowAdSpot"]:''}}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<h2 style="color:#009688">{!! trans('flashcard.emailMarketingSetting') !!}</h2>
					<hr style="margin-top: 10px;border-color: #9BBDD1;">
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group" style="padding-top:20px;">
						<label for="siteTitle" class="pull-left" style="font-size:16px;width:270px;margin-top:-5px">
							{!! trans('flashcard.selectMailingService') !!}<br>
							<span style="font-size:12px;font-weight:normal;font-style: italic">
								{!! trans('flashcard.msg10') !!}
							</span>
						</label>
						<select class="form-control" name="mailService" id="mailService" style="max-width:350px;" onchange="fetchMailList()">
							<option value=''>{!! trans('flashcard.selectMailingServiceDrop') !!}</option>
							<option value="mailchimp" {{isset($settings['mailService'])?($settings["mailService"] == 'mailchimp'?'selected=selected':''):''}}>MailChimp</option>
							<option value="sendinblue" {{isset($settings['mailService'])?($settings["mailService"] == 'sendinblue'?'selected=selected':''):''}}>Sendinblue</option>
							<option value="convertkit" {{isset($settings['mailService'])?($settings["mailService"] == 'convertkit'?'selected=selected':''):''}}>ConvertKit</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row" id="accountNameRow">
				<div class="col-md-8">
					<div class="form-group" style="padding-top:30px;">
						<label for="siteTitle" class="pull-left" style="font-size:16px;width:270px;margin-top:-5px">
							{!! trans('flashcard.accountName') !!}<br>
							<span style="font-size:12px;font-weight:normal;font-style: italic">{!! trans('flashcard.msg11') !!}</span>
						</label>
						<input type="text" class="form-control pull-left" style="width:350px" name="accountName" value="{{isset($settings['accountName'])? $settings["accountName"]:''}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group" style="padding-top:30px;">
						<label for="siteTitle" class="pull-left" style="font-size:16px;width:270px;margin-top:-5px">
							{!! trans('flashcard.apiKey') !!}<br>
							<span style="font-size:12px;font-weight:normal;font-style: italic">{!! trans('flashcard.msg12') !!}</span>
						</label>
						<input type="text" class="form-control pull-left" style="width:350px" name="apiKey" id="apiKey" value="{{isset($settings['apiKey'])? $settings["apiKey"]:''}}" onblur="fetchMailList()">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group" style="padding-top:20px;">
						<label for="siteTitle" class="pull-left" style="font-size:16px;width:270px;margin-top:-5px">
							{!! trans('flashcard.optInList') !!}<br>
							<span style="font-size:12px;font-weight:normal;font-style: italic">
								{!! trans('flashcard.msg13') !!}
							</span>
						</label>
						<select class="form-control" style="max-width:350px;" name="mailListId" id="mailListId">
						</select>
					</div>
				</div>
			</div>
			<div style="padding-top:20px">
				<button type="submit" class="btn btn-success">{!! trans('flashcard.save') !!}</button>
			</div>
		</form>

	</section>
	<script type="text/javascript">
		var mailService;
		var apiKey;
		var mailListId;
		$(function(){
			@if(isset($settings['mailService']))
				mailService = '{{$settings['mailService']}}'
			@endif

			@if(isset($settings['apiKey']))
				apiKey = '{{$settings['apiKey']}}'
			@endif

			@if(isset($settings['mailListId']))
				mailListId = '{{$settings['mailListId']}}'
			@endif

			console.log(mailListId);
			if(mailService&&apiKey)
				fetchMailList();
		});
		function fetchMailList() {
			mailService = $("#mailService").val();
			if(mailService == 'convertkit') {
				$("#accountNameRow").hide()
			} else {
				$("#accountNameRow").show()
			}
			apiKey = $("#apiKey").val();
			if(!apiKey) return;
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			$.ajax({
				url:"{{ Config::get('RELATIVE_URL') }}/fetchMailList",//"https://api.sendinblue.com/v2.0/list?page=1&page_limit=100",
				data:{
					apiKey:apiKey,
					mailService:mailService,
					_token: CSRF_TOKEN
				},
				method: 'POST',
				dataType:"json"
			}).then(function(ret){
				console.log(ret);
				$("#mailListId").html("");
				if(mailService == 'sendinblue') {
					ret = JSON.parse(ret);
					if(ret.code=='success') {
						var list = ret.data.lists;
						var mailListSelect = $("#mailListId")[0];
						list.map(function(o){
							console.log(o);
							var option = new Option(o.name, o.id);
							if(mailListId && mailListId == o.id) {
								option.selected=true;
							}
							mailListSelect.add(option);
						})
					}
				} else if(mailService == 'convertkit') {
					var sequences = JSON.parse(ret.sequences);
					var forms = JSON.parse(ret.forms);
					if(forms.forms && forms.forms.length > 0) {
						var list = forms.forms;
						var mailListSelect = $("#mailListId")[0];
						list.map(function(o){
							var option = new Option("[Form] " + o.name, "form|" + o.id);
							if(mailListId && mailListId == "form|" + o.id) {
								option.selected=true;
							}
							mailListSelect.add(option);
						})
					}
					if(sequences.courses && sequences.courses.length > 0) {
						var list = sequences.courses;
						var mailListSelect = $("#mailListId")[0];
						list.map(function(o){
							var option = new Option("[Sequence] " + o.name, "sequence|" + o.id);
							if(mailListId && mailListId == "sequence|" + o.id) {
								option.selected=true;
							}
							mailListSelect.add(option);
						})
					}
				} else if(mailService == 'mailchimp' && ret.total_items) {
					var list = ret.lists;
					var mailListSelect = $("#mailListId")[0];
					list.map(function(o){
						var option = new Option(o.name, o.id);
						if(mailListId && mailListId == o.id) {
							option.selected=true;
						}
						mailListSelect.add(option);
					})
				}
			}, function(err){
				console.log(err);
			})
		}
	</script>
@endsection