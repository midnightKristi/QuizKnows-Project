<?php

namespace App;

/******************************************************
 * Flashcard script
 * Version : {version}
 * Copyright© 2016 Avrasys Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:https://flashcardscript.com
 ******************************************************/

use Illuminate\Database\Eloquent\Model;
use App\Word;

class Code extends Model
{
	protected $fillable = ['code_name', 'code_value'];
}
