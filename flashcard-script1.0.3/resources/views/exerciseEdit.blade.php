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
		<!-- Add New Exercise -->
		<h2 class="page-header">{!! trans('flashcard.editExercise') !!}</h2>
		@include('common.errors')
		<div class="row">
			<div class="col-md-4">
				<form id="postForm" method="post" action="{{ Config::get('RELATIVE_URL') }}/exercises/{{$exercise->id}}/edit">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="exampleInputEmail1">{!! trans('flashcard.title') !!}</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="{!! trans('flashcard.enterTitle') !!}" value="{{$exercise->title}}" required>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">{!! trans('flashcard.selectCategory') !!}</label>
						<div>
							@foreach ($cats as $cat)
								<span style="padding-right:20px;display:inline-block;">{{$cat->category}}&nbsp;&nbsp;<input type="checkbox" id="catCheck" value="{{$cat->id}}"></span>
							@endforeach
							<input type="hidden" name="category">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputFile">{!! trans('flashcard.randomizeWords') !!}</label>
						<div>
							<input type="radio" name="randomWord" id="optionsRadios1" value="1" @if($exercise->randomWord==1)checked="checked"@endif> {!! trans('flashcard.yes') !!}
						</div>
						<div>
							<input type="radio" name="randomWord" id="optionsRadios1" value="0" @if($exercise->randomWord==0)checked="checked"@endif> {!! trans('flashcard.no') !!}
						</div>
					</div>
					<div class="form-group">
						<label>{!! trans('flashcard.adSettings') !!}</label>
						<div>
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.enableInlineAd') !!}&nbsp;&nbsp;<input type="checkbox" name="enableInlineAd" id="enableInlineAd" value="Y" @if($exercise->enableInlineAd=='Y')checked="checked"@endif></span>
						</div>
						<div>
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.showInlineAd') !!}&nbsp;&nbsp;
								<input type="input" name="adCount" id="adCount" style="width:30px;text-align:center" value="{{$exercise->adCount}}">&nbsp;{!! trans('flashcard.timesInThisExercise') !!}
							</span>
						</div>
						<div>
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.enableBelowExerciseAd') !!}&nbsp;&nbsp;<input type="checkbox" name="enableBelowExerciseAd" id="enableBelowExerciseAd" value="Y" @if($exercise->enableBelowExerciseAd=='Y')checked="checked"@endif></span>
						</div>
					</div>
					<div class="form-group">
						<label>{!! trans('flashcard.emailMarketingSetting') !!}</label>
						<div style="line-height:32px">
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.enableEmailMarketing') !!}&nbsp;&nbsp;<input type="checkbox" name="enableEmailMarketing" id="enableEmailMarketing" value="Y" @if($exercise->enableEmailMarketing=='Y')checked="checked"@endif></span>
						</div>
						<div>
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.showSubscriptionForm') !!}&nbsp;&nbsp;
								<input type="input" name="subscriptionCount" id="subscriptionCount" style="width:30px;text-align:center" value="{{$exercise->subscriptionCount}}">&nbsp;{!! trans('flashcard.timesInThisExercise') !!}
							</span>
						</div>
					</div>
					<div>
						<button type="submit" class="btn btn-success">{!! trans('flashcard.save') !!}</button>
					</div>
				</form>
			</div>
		</div>
		<!-- END Add New Words -->
	</section>
	<script>
		$(function(){
			var category = "{{$exercise->category}}";
			var ids = category.split(",");
			$("input#catCheck").each(function(){
				if(ids.indexOf(this.value) != -1) {
					this.checked = true;
				}
			});

			$("#postForm").submit(function(){

				category = "";
				$("input#catCheck").each(function(){
					if(this.checked) {
						category += this.value + ","
					}
				});

				if(category == "") {
					alert("{!! trans('flashcard.pleaseSelectCategory') !!}");
					return false;
				}

				category = category.substr(0, category.length - 1);

				$("input[name=category]").val(category);

				$("#postForm").submit();
			});
		});
	</script>
@endsection
