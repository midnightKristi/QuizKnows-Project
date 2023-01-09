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
          <!-- Add New Words -->
          <h2 class="page-header">{!! trans('flashcard.editCategory') !!}</h2>
          @include('common.errors')
          <form method="post" action="{{ Config::get('RELATIVE_URL') }}/cats/{{$cat->id}}/edit">
          {{ csrf_field() }}
          <div>
          	<input type="text" class="form-control" id="categoryText" name="category" placeholder="Enter category" style="width:300px;margin-bottom:20px;" value="{{$cat->category}}">
          </div>
          <div>
	      	<button type="submit" class="btn btn-success">&nbsp;&nbsp;{!! trans('flashcard.save') !!}&nbsp;&nbsp;</button>
	      	<button class="btn btn-primary" onclick="location.href='{{ Config::get('RELATIVE_URL') }}/cats';return false;">&nbsp;&nbsp;{!! trans('flashcard.back') !!}&nbsp;&nbsp;</button>
          </div>
          </form>
          <!-- END Add New Words -->
        </section>
@endsection
