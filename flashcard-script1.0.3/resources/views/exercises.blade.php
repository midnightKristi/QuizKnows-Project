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
		<h2 class="page-header">{!! trans('flashcard.createNewExercise') !!}</h2>
		@include('common.errors')
		<div class="row">
			<div class="col-md-4">
				<form id="postForm" method="post" action="{{ Config::get('RELATIVE_URL') }}/exercise">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="title">{!! trans('flashcard.title') !!}</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="{!! trans('flashcard.enterTitle') !!}" required>
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
							<input type="radio" name="randomWord" id="optionsRadios1" value="1" checked="checked"> {!! trans('flashcard.yes') !!}
						</div>
						<div>
							<input type="radio" name="randomWord" id="optionsRadios1" value="0"> {!! trans('flashcard.no') !!}
						</div>
					</div>
					<div class="form-group">
						<label>{!! trans('flashcard.adSettings') !!}</label>
						<div>
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.enableInlineAd') !!}&nbsp;&nbsp;<input type="checkbox" name="enableInlineAd" id="enableInlineAd" value="Y"></span>
						</div>
						<div>
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.showInlineAd') !!}&nbsp;&nbsp;
								<input type="input" name="adCount" id="adCount" style="width:30px;text-align:center" value="4">&nbsp;{!! trans('flashcard.timesInThisExercise') !!}
							</span>
						</div>
						<div>
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.enableBelowExerciseAd') !!}&nbsp;&nbsp;<input type="checkbox" name="enableBelowExerciseAd" id="enableBelowExerciseAd" value="Y"></span>
						</div>
					</div>
					<div class="form-group">
						<label>{!! trans('flashcard.emailMarketingSetting') !!}</label>
						<div style="line-height:32px">
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.enableEmailMarketing') !!}&nbsp;&nbsp;<input type="checkbox" name="enableEmailMarketing" id="enableEmailMarketing" value="Y"></span>
						</div>
						<div>
							<span style="padding-right:20px;display:inline-block;">{!! trans('flashcard.showSubscriptionForm') !!}&nbsp;&nbsp;
								<input type="input" name="subscriptionCount" id="subscriptionCount" style="width:30px;text-align:center" value="4">&nbsp;{!! trans('flashcard.timesInThisExercise') !!}
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

		<!-- START Available words-->
		<h2 class="page-header" style="margin-top:50px;">{!! trans('flashcard.availableExercises') !!}</h2>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody><tr>
								<th style="width:50px;text-align:center">#</th>
								<th>{!! trans('flashcard.exerciseTitle') !!}</th>
								<th>{!! trans('flashcard.embedCode') !!}</th>
								<th>{!! trans('flashcard.actions') !!}</th>
							</tr>
							<?php $cnt = 0 ?>
							@foreach ($exercises as $exercise)
								<?php $cnt++ ?>
								<tr>
									<td style="text-align:center">{{$cnt}}</td>
									<td>{{$exercise->title}}</td>
									<td><pre style="max-width:800px">{{$exercise->embed}}</pre></td>
									<td>
                      	<span style="float:left;padding-right:10px;">
							<form action="{{ Config::get('RELATIVE_URL') }}/exercises/{{ $exercise->id }}/edit" method="GET">
								<button class="btn btn-info btn-xs" style="width:50px;">{!! trans('flashcard.edit') !!}</button>
							</form>
                      	</span>
                      	<span style="float:left;">
							<form action="{{ Config::get('RELATIVE_URL') }}/exercises/{{ $exercise->id }}" method="POST">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
								<button type="submit" class="btn btn-danger btn-xs" style="width:50px;">{!! trans('flashcard.delete') !!}</button>
							</form>
                      	</span>
									</td>
								</tr>
							@endforeach
							</tbody></table>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div><!-- /.row -->
		<!-- END Available words-->
	</section>
	<script>
		$(function(){
			$("#postForm").submit(function(){

				var category = "";
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
