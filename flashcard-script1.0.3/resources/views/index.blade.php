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
          <h2 class="page-header">{!! trans('flashcard.addNewWords') !!}</h2>
          @include('common.errors')
          <form method="post" action="{{ Config::get('RELATIVE_URL') }}/word" encType="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{!! trans('flashcard.word') !!}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	<textarea class="form-control" name="wordDesc" rows="4" placeholder="{!! trans('flashcard.msg6') !!}"></textarea>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col (left) -->
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{!! trans('flashcard.audio') !!}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	<button class="btn btn-block btn-default btn-lg" onclick="chooseAudioFile();return false;" style="margin-bottom:10px;opacity:0.7;"><i class="fa fa-cloud-upload"></i>&nbsp;&nbsp; {!! trans('flashcard.uploadAudio') !!}</button>
                	<p>{!! trans('flashcard.msg1') !!}</p>
                	<div style="display:none"><input type="file" name="audioFile" accept="audio/*"></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col (left) -->
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{!! trans('flashcard.exampleSentence') !!}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	<textarea class="form-control" name="example" rows="4" placeholder="{!! trans('flashcard.msg2') !!}"></textarea>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col (left) -->
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{!! trans('flashcard.selectCategory') !!}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	<select name="categoryId" class="form-control">
                		@foreach ($cats as $cat)
	                        <option value="{{ $cat->id }}">{{ $cat->category }}&nbsp;({{ $cat->count }})</option>
						        @endforeach
                    </select>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col (left) -->
          </div><!-- /.row -->
       	  <button type="submit" class="btn btn-success">&nbsp;&nbsp;{!! trans('flashcard.add') !!}&nbsp;&nbsp;</button>
       	  </form>
          <!-- END Add New Words -->
			
          <!-- START Available words-->
          <h2 class="page-header" style="margin-top:50px;">{!! trans('flashcard.availableWords') !!}</h2>
          <div class="row">
          	<div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <form method="get" action="{{ Config::get('RELATIVE_URL') }}/words">
                    <div class="input-group" style="width: 300px;">
	                      <input type="text" name="query" class="form-control input-sm pull-right" placeholder="{!! trans('flashcard.search') !!}" value="{{$query}}">
	                      <div class="input-group-btn">
	                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
	                      </div>
                    </div>
                    </form>
                    <div class="box-tools">
	                    {!! $words->appends(['query' => $query])->render() !!}
	                </div>
                  </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tbody><tr>
                      <th>{!! trans('flashcard.nameOfTheWord') !!}</th>
                      <th>{!! trans('flashcard.audio') !!}</th>
                      <th>{!! trans('flashcard.category') !!}</th>
                      <th>{!! trans('flashcard.actions') !!}</th>
                    </tr>
                    @foreach ($words as $word)
                    <tr>
                      <td>{{$word->word}}</td>
                      <td>
                      	@if ($word->audio == '')
                      	<a style="color:#00a65a;"><i class="fa fa-close fa-2x"></i></a>
                      	@else
                      	<a style="color:#00a65a;"><i class="fa fa-check fa-2x"></i></a>
                      	@endif
                      </td>
                      <td>{{$word->category}}</td>
                      <td>
                      	<span style="float:left;padding-right:10px;">
							<form action="{{ Config::get('RELATIVE_URL') }}/words/{{ $word->id }}/edit" method="GET">
	                      		<button class="btn btn-info btn-xs" style="width:50px;">{!! trans('flashcard.edit') !!}</button>
	                      	</form>
                      	</span>
                      	<span style="float:left;">
							<form action="{{ Config::get('RELATIVE_URL') }}/words/{{ $word->id }}" method="POST">
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
function chooseAudioFile() {
	$("input[name='audioFile']").click();
}
</script>
@endsection