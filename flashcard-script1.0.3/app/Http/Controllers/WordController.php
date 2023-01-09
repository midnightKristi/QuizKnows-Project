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
use App\Word;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Config;
use Redirect;

class WordController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
    	/* $words = Word::join('cats', 'words.categoryId', '=', 'cats.id')
    	->select('words.*', 'cats.category')->paginate(10);
    	
    	return $words; */
    	
    	$query = $request->input('query');
    	if($query == null)
    		$query = '';
    	
    	$words = Word::join('cats', 'words.categoryId', '=', 'cats.id')->where('words.word', 'like', '%'.$query.'%')
    	->select('words.*', 'cats.category')->paginate(10);
    	$words->setPath(Config::get('RELATIVE_URL').'/words');
    
        return view('index', [
            'cats' => Cat::leftJoin('words', 'cats.id', '=', 'words.categoryId')
            ->select('cats.*', DB::raw('count(words.categoryId) as count'))
			->groupBy('cats.id')
            ->get(),
        	'words' => $words,
        	'query' => $query,
        ]);
    }
    
    public function edit($id)
    {
    	$word = Word::findOrNew($id);
    	if($word->audio != '' && $word->audio != null) {
    		$pos = strrpos($word->audio, "/");
    		$word->audio = substr($word->audio, $pos + 1);
    	}
    	return view('wordEdit', [
    			'cats' => Cat::leftJoin('words', 'cats.id', '=', 'words.categoryId')
		            ->select('cats.*', DB::raw('count(words.categoryId) as count'))
					->groupBy('cats.id')
		            ->get(),
    			'word' => $word,
    	]);
    }
    
    public function postEdit(Request $request, $id)
    {
    	$word = Word::findOrNew($id);
    	
    	$this->validate($request, [
    			'wordDesc' => 'required|max:255',
				'categoryId' => 'required'
		]);
		$params = explode('|', $request->input('wordDesc'));
		if(count($params) < 2) {
			return Redirect::back()->withErrors(trans('validation.wrong_word_desc'));
		}
		$word->word = $params[0];
		$word->desc = $params[1];
    	
		$word->example = $request->input("example");
    	$word->categoryId = $request->input("categoryId");
    	
    	//save audio file
    	$attributes = Input::all();
    	$fileUrl = null;
    	if (isset($attributes['audioFile'])) {
    	
    		$file = $attributes['audioFile'];
    	
    		// delete old image
    		$destinationPath = public_path() . "/upload/audio";
    		$fileName = time().'_'.$file->getClientOriginalName();
    		$fileSize = $file->getClientSize();
    		$upload_success = $file->move($destinationPath, $fileName);
    	
    		if ($upload_success) {
    			$fileUrl = "/upload/audio/".$fileName;
    			$word->audio = $fileUrl;
    		}
    	}
    	
    	$word->save();

    	return redirect('/');
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
            'wordDesc' => 'required|max:255',
			'categoryId' => 'required'
        ]);

		$params = explode('|', $request->input('wordDesc'));
		if(count($params) < 2) {
			return Redirect::back()->withErrors(trans('validation.wrong_word_desc'));
		}
		$word = $params[0];
		$desc = $params[1];

        //save audio file
        $attributes = Input::all();
        $fileUrl = null;
        if (isset($attributes['audioFile'])) {
        
        	$file = $attributes['audioFile'];
        
        	// delete old image
        	$destinationPath = public_path() . "/upload/audio";
        	$fileName = time().'_'.$file->getClientOriginalName();
        	$fileSize = $file->getClientSize();
        	$upload_success = $file->move($destinationPath, $fileName);
        
        	if ($upload_success) {
        		$fileUrl = "/upload/audio/".$fileName;
        	}
        }
        Word::create([
            'word' => $word,
            'desc' => $desc,
            'audio' => $fileUrl,
        	'example' => $request->input('example'),
            'categoryId' => $request->input('categoryId'),
        ]);

        return redirect('/');
    }

    public function destroy($id)
    {
    	$word = Word::findOrNew($id);
        //$this->authorize('destroy', $category);
		//Cat::destroy([$category]);
        $word->delete();

        return redirect('/');
    }
    
    public function getWords(Request $request) 
    {
    	$categoryIds = $request->input('categoryId');
		$categoryIdList = explode(",", $categoryIds);
		$words = [];
		for($i = 0; $i < sizeof($categoryIdList); ++$i)
		{
			//$words = Word::where('categoryId', $categoryIdList[$i])->get();
			$list = Word::where('categoryId', $categoryIdList[$i])->get();
			for($j = 0 ; $j < sizeof($list) ; $j++) {
				$item = $list[$j];
				array_push($words,$item);
			}
		}
		return $words;
    }
}
