<?php
use App\Cat;
use App\Word;
use App\Code;
use App\Exercise;
use Illuminate\Support\Facades\Input;

//$languages = ['en', 'zh'];
// $relPath = $_ENV['RELATIVE_URL'];
$relPath = env('RELATIVE_URL');
Config::set('RELATIVE_URL', $relPath);
//Session::put('relPath', $relPath);

$locale = Code::where("code_name", "lang")->first()->code_value;
App::setLocale($locale);

$title = "IMPREVO";
$titleObj = Code::where("code_name", "title")->first();
if($titleObj)
	$title = $titleObj->code_value;
	
Config::set('SITE_TITLE', $title);

Route::get ( '/exercise/{id}', function ($id) {
	$exercise = Exercise::findOrNew($id);
	$codeList = Code::all();
	$settings = [];
	for($i = 0; $i < count($codeList); $i++) {
		$settings[$codeList[$i]["code_name"]] = $codeList[$i]["code_value"];
	}

	$list = explode(',', $exercise->category);
	
	return view ( 'exercise', [
			'cats' => Cat::leftJoin ( 'words', 'cats.id', '=', 'words.categoryId' )->whereIn('cats.id', $list)->select ( 'cats.*', DB::raw ( 'count(words.categoryId) as count' ) )->groupBy ( 'cats.id' )->get (),
			'exercise' => $exercise,
			'settings' => $settings
	] );
} );
Route::get ( '/getWords', 'WordController@getWords' );

Route::get('/', ['as' => 'admin.login', 'uses' => 'Auth\AuthController@getLogin']);
Route::get('/login', ['as' => 'admin.login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/login', ['as' => 'admin.login.post', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'Auth\AuthController@getLogout']);
// Registration Routes...
Route::get('/register', ['as' => 'admin.register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('/register', ['as' => 'admin.register.post', 'uses' => 'Auth\AuthController@postRegister']);

Route::get('forgot-password', array('as'   => 'admin.forgot.password',
		'uses' => 'Auth\AuthController@getForgotPassword'));
Route::post('forgot-password', array('as'   => 'admin.forgot.password.post',
		'uses' => 'Auth\AuthController@postForgotPassword'));


Route::post('/fetchMailList', ['uses' => 'Auth\AuthController@fetchMailList']);
Route::post('/subscribe', ['uses' => 'Auth\AuthController@subscribe']);

//words
Route::get('/words', ['as' => 'admin.index', 'uses' => 'WordController@index']);
Route::post('/word', ['as' => 'admin.word.post', 'uses' => 'WordController@create']);
Route::get('/words/{id}/edit', ['as' => 'admin.words.edit', 'uses' => 'WordController@edit']);
Route::post('/words/{id}/edit', ['as' => 'admin.words.edit.post', 'uses' => 'WordController@postEdit']);
Route::delete('/words/{id}', ['as' => 'admin.word.delete', 'uses' => 'WordController@destroy']);

//categories
Route::get('/cats', ['as' => 'admin.categories', 'uses' => 'CategoryController@index']);
Route::post('/cat', ['as' => 'admin.category.post', 'uses' => 'CategoryController@create']);
Route::get('/cats/{id}/edit', ['as' => 'admin.categories.edit', 'uses' => 'CategoryController@edit']);
Route::post('/cats/{id}/edit', ['as' => 'admin.categories.edit.post', 'uses' => 'CategoryController@postEdit']);
Route::delete('/cats/{id}', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@destroy']);

//exercises
Route::get('/exercises', ['as' => 'admin.exercises', 'uses' => 'ExerciseController@index']);
Route::post('/exercise', ['as' => 'admin.exercise.post', 'uses' => 'ExerciseController@create']);
Route::get('/exercises/{id}/edit', ['as' => 'admin.exercises.edit', 'uses' => 'ExerciseController@edit']);
Route::post('/exercises/{id}/edit', ['as' => 'admin.exercises.edit.post', 'uses' => 'ExerciseController@postEdit']);
Route::delete('/exercises/{id}', ['as' => 'admin.exercise.delete', 'uses' => 'ExerciseController@destroy']);

//setting
Route::get('/setting', ['as' => 'admin.setting', 'uses' => 'Auth\AuthController@setting']);
Route::post('/setting', ['as' => 'admin.setting.post', 'uses' => 'Auth\AuthController@postSetting']);
Route::get('/profile', ['as' => 'admin.profile', 'uses' => 'Auth\AuthController@profile']);
Route::post('/profile', ['as' => 'admin.profile.post', 'uses' => 'Auth\AuthController@postProfile']);

/* Route::get ( '/{any}', function () {
	return Redirect::to ( App::getLocale ().'/404', 302 );
} );

Route::group(array('prefix' => App::getLocale(), 'before' => array('localization', 'before')), function () {
	Session::put('my.locale', App::getLocale());
	Route::get ( '/404', function () {
		return view ( '404', [ 
				'link' => "" 
		] );
	} );
}); */
