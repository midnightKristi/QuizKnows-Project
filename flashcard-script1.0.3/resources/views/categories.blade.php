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
          <h2 class="page-header">{!! trans('flashcard.createNewCategory') !!}</h2>
          @include('common.errors')
          <form method="post" action="{{ Config::get('RELATIVE_URL') }}/cat">
          {{ csrf_field() }}
          <div>
          	<input type="text" class="form-control" id="categoryText" name="category" placeholder="{!! trans('flashcard.enterCategory') !!}" style="width:300px;margin-bottom:20px;">
          </div>
          <div>
	      	<button type="submit" class="btn btn-success">&nbsp;&nbsp;{!! trans('flashcard.add') !!}&nbsp;&nbsp;</button>
          </div>
          </form>
          <!-- END Add New Words -->

          <!-- START Available words-->
          <h2 class="page-header" style="margin-top:50px;">{!! trans('flashcard.availableCategories') !!}</h2>
          <div class="row">
          	<div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tbody><tr>
                      <th>{!! trans('flashcard.categoryName') !!}</th>
                      <th>{!! trans('flashcard.actions') !!}</th>
                    </tr>
                    @foreach ($cats as $cat)
					<tr>
						<td>{{ $cat->category }}</td>

						<!-- Task Delete Button -->
						<td>
	                      	<span style="float:left;padding-right:10px;">
								<form action="{{ Config::get('RELATIVE_URL') }}/cats/{{ $cat->id }}/edit" method="GET">
		                      		<button class="btn btn-info btn-xs" style="width:50px;">{!! trans('flashcard.edit') !!}</button>
		                      	</form>
	                      	</span>
	                      	<span style="float:left;">
								<form action="{{ Config::get('RELATIVE_URL') }}/cats/{{ $cat->id }}" method="POST">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
		                      		<button type="submit" id="delete-category-{{ $cat->id }}" class="btn btn-danger btn-xs" style="width:50px;">{!! trans('flashcard.delete') !!}</button>
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
@endsection
