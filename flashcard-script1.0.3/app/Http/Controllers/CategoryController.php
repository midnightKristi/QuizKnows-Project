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
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view('categories', [
            'cats' => Cat::all(),
        ]);
    }
    
    public function edit($id)
    {
    	return view('categoryEdit', [
    			'cat' => Cat::findOrNew($id),
    	]);
    }
    
    public function postEdit(Request $request, $id)
    {
    	$cat = Cat::findOrNew($id);
    	$cat->category = $request->input("category");
    	$cat->save();//->updateOrCreate(['category'=>$request->input("category")]);

    	return redirect('/cats');
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
            'category' => 'required|max:255',
        ]);

        Cat::create([
            'category' => $request->get('category'),
        ]);

        return redirect('/cats');
    }

    public function destroy($id)
    {
    	$cat = Cat::findOrNew($id);
        //$this->authorize('destroy', $category);
		//Cat::destroy([$category]);
        $cat->delete();

        return redirect('/cats');
    }
}
