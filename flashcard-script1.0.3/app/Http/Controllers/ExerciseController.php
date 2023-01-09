<?php

namespace App\Http\Controllers;

/******************************************************
 * Flashcard script
 * Version : {version}
 * Copyright© 2016 Avrasys Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:https://flashcardscript.com
 ******************************************************/

use App\Cat;
use App\Exercise;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Illuminate\Support\Facades\URL;

class ExerciseController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view('exercises', [
            'cats' => Cat::all(),
            'exercises' => Exercise::all(),
        ]);
    }
    
    public function edit($id)
    {
    	$exercise = Exercise::findOrNew($id);
    	return view('exerciseEdit', [
    			'cats' => Cat::all(),
    			'exercise' => $exercise,
    	]);
    }
    
    public function postEdit(Request $request, $id)
    {
    	$exercise = Exercise::findOrNew($id);
    	
    	$this->validate($request, [
    			'title' => 'required|max:255',
    			'category' => 'required'
    	]);
    	$embed = "<object width=\"100%\" height=\"570\" type=\"text/html\" data=\"".$request->root()."/exercise/".$id."\"></object>";
    	$exercise->embed = $embed;
    	 
    	$exercise->title =  $request->input("title");
    	$exercise->category =  $request->input("category");
        $exercise->randomWord = $request->input("randomWord");
        $exercise->enableInlineAd = $request->input("enableInlineAd");
        $exercise->adCount = $request->input("adCount");
        $exercise->enableBelowExerciseAd = $request->input("enableBelowExerciseAd");
        $exercise->enableEmailMarketing = $request->input("enableEmailMarketing");
        $exercise->subscriptionCount = $request->input("subscriptionCount");
    	$exercise->save();

    	return redirect('/exercises');
    }
    
    /**
     * Create a new category.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
    			'title' => 'required|max:255',
    			'category' => 'required'
    	]);
        
        $exercise = Exercise::create([
            'title' => $request->input("title"),
            'category' => $request->input("category"),
            'randomWord' => $request->input("randomWord"),
            'enableInlineAd' => $request->input("enableInlineAd"),
            'adCount' => $request->input("adCount"),
            'enableBelowExerciseAd' => $request->input("enableBelowExerciseAd"),
            'enableEmailMarketing' => $request->input("enableEmailMarketing"),
            'subscriptionCount' => $request->input("subscriptionCount"),
        ]);
        
        //update embedcode after exercise
        $embed = "<object width=\"100%\" height=\"570\" type=\"text/html\" data=\"".$request->root()."/exercise/".$exercise->id."\"></object>";
        $exercise->embed = $embed;
        $exercise->update();
        
        return redirect('/exercises');
    }

    public function destroy($id)
    {
    	$exercise = Exercise::findOrNew($id);
        $exercise->delete();

        return redirect('/exercises');
    }
}
