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
          <h2 class="page-header">{!! trans('flashcard.editWord') !!}</h2>
          @include('common.errors')
          <form method="post" action="{{ Config::get('RELATIVE_URL') }}/words/{{$word->id}}/edit" encType="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{!! trans('flashcard.word') !!}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                	<textarea class="form-control" name="wordDesc" rows="4" placeholder="{!! trans('flashcard.msg6') !!}">{{$word->word}}|{{$word->desc}}</textarea>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col (left) -->
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">{!! trans('flashcard.audio') !!}</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="word-break:break-all;">
                	{{$word->audio}}
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
                	<textarea class="form-control" name="example" rows="4" placeholder="{!! trans('flashcard.msg2') !!}">{{$word->example}}</textarea>
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
	                        <option value="{{ $cat->id }}" @if ($word->categoryId==$cat->id) selected="selected" @endif>{{ $cat->category }}({{ $cat->count }})</option>
						@endforeach
                    </select>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col (left) -->
          </div><!-- /.row -->
       	  <button type="submit" class="btn btn-success">&nbsp;&nbsp;{!! trans('flashcard.save') !!}&nbsp;&nbsp;</button>
       	  <button class="btn btn-primary" onclick="location.href='/admin';return false;">&nbsp;&nbsp;{!! trans('flashcard.back') !!}&nbsp;&nbsp;</button>
       	  </form>
          <!-- END Add New Words -->
          <!-- END Available words-->
        </section>
<script>
function chooseAudioFile() {
	$("input[name='audioFile']").click();
}
</script>
@endsection