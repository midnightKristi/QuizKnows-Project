<?php

namespace App\Http\Controllers\Auth;

/******************************************************
 * Flashcard script
 * Version : {version}
 * Copyright© 2016 Avrasys Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:https://flashcardscript.com
 ******************************************************/

use App\User;
use App\Code;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Sentinel;
use Redirect;
use Input;
use Reminder;
use Mail;
use Session;
use File;
use stdClass;

require_once __DIR__.'/../../../include/MailChimp.php';
require_once __DIR__.'/../../../include/Mailin.php';
use MailChimp;
use Mailin;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Display the login page
     * @return View
     */
    public function getLogin()
    {
    	if(!Sentinel::check())
    		return view('login');
    
    	return Redirect::route('admin.index');
    }
    
    public function getLogout()
    {
    	Sentinel::logout(Sentinel::getUser());
    	return Redirect::route('admin.login');
    }
    
    /**
     * Login action
     * @param Request $request
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $credentials = array(
            'username'    => $request->get('username'),
            'password' => $request->get('password')
        );

        $rememberMe = $request->get('rememberMe');
        
        try
        {
            if(!empty($rememberMe))
                $result = Sentinel::authenticateAndRemember($credentials);
            else
                $result = Sentinel::authenticate($credentials);

            //Log::info("Kullan�c� (".$request->get('email').") sisteme giri� yapt�");

            if($result)
                return Redirect::route('admin.index');
        } catch(\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        //flash()->error('Invalid user id or password!');
        return Redirect::back()->withErrors("Invalid username or password!");
    }
    
    public function getRegister()
    {
    	try
    	{
	    	$admindata = file_get_contents("./install/.temp");
	    	list($adminname, $adminpassword, $adminemail) = explode('\n\r', $admindata);
	    	$result = Sentinel::registerAndActivate([
	    			'username' => $adminname,
	    			'email'    => $adminemail,
	    			'password' => $adminpassword,
	    	]);
	    	
	    	//Log::info("Kullan�c� (".$request->get('email').") sisteme giri� yapt�");
	    	
	    	if($result)
		    	return Redirect::away('./install/installComplete.php');
	    } 
	    catch(\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e)
    	{
    		return Redirect::away('./install/admin_setting.php?error=1');
    	}
    	//return view('register');
    	return Redirect::away('./install/admin_setting.php?error=1');
    }
    
    public function postRegister(Request $request)
    {
    	try
    	{
    		$result = Sentinel::registerAndActivate([
    				'username' => $request->get('username'),
    				'email'    => $request->get('email'),
    				'password' => $request->get('password'),    				
    		]);
    
    		//Log::info("Kullan�c� (".$request->get('email').") sisteme giri� yapt�");
    
    		if($result)
    			return Redirect::route('admin.login');
    	} catch(\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e)
    	{
    		return Redirect::back()->withErrors($e->getMessage());
    	}
    
    	//flash()->error('Invalid user id or password!');
    	return Redirect::back()->withInput();
    }
    
    public function setting()
    {
    	if(!Sentinel::check())
    		return view('login');
    	
    	//get directory listing
    	$basePath = base_path();
    	$list = File::directories($basePath.'/resources/lang');
    	$langStr = "";
    	for($i = 0; $i < count($list); $i++) {
    		$langStr = $langStr.substr($list[$i], strrpos($list[$i], '/lang') + 6).',';
    	}
    	
    	if(strlen($langStr) > 0) {
    		$langStr = substr($langStr, 0, strlen($langStr) - 1);
    	}

		$codeList = Code::all();
		$settings = [];
		for($i = 0; $i < count($codeList); $i++) {
			$settings[$codeList[$i]["code_name"]] = $codeList[$i]["code_value"];
		}
    	
    	return view('setting', ['langStr' =>$langStr, 'settings'=>$settings]);
    }

	public function fetchMailList(Request $request) {
		$apiKey = $request->get('apiKey');
		$mailService = $request->get('mailService');
		if($mailService == 'sendinblue') {
			$ch = curl_init();
			$headers = array(
					'api-key:'.$apiKey
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_URL, 'https://api.sendinblue.com/v2.0/list?page=1&page_limit=100');
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$result = curl_exec($ch);
			if ( ! $result) {
				echo curl_errno($ch) .': '. curl_error($ch);
			}

			curl_close($ch);
			//echo $status_code;
			//var_dump($result);
			return json_encode($result);
		} else if($mailService == 'convertkit') {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_URL, 'https://api.convertkit.com/v3/courses?api_key='.$apiKey);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$result = curl_exec($ch);
			if ( ! $result) {
				echo curl_errno($ch) .': '. curl_error($ch);
			}

			curl_close($ch);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_URL, 'https://api.convertkit.com/v3/forms?api_key='.$apiKey);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$result2 = curl_exec($ch);
			if ( ! $result) {
				echo curl_errno($ch) .': '. curl_error($ch);
			}

			curl_close($ch);
			//echo $status_code;
			//var_dump($result);
			return json_encode(array("sequences"=>$result, "forms"=>$result2));
		} else if($mailService == 'mailchimp') {

			try {
				$api = new MailChimp($apiKey);
				$retval = $api->get('lists');
				return json_encode($retval);
			} catch(Exception $e) {
				return json_encode(array("error"=>"Failed"));
			}
		}
	}

	public function subscribe(Request $request) {
		$email = $request->get('email');
		$codeList = Code::all();
		$settings = [];

		for($i = 0; $i < count($codeList); $i++) {
			$settings[$codeList[$i]["code_name"]] = $codeList[$i]["code_value"];
		}

		$apiKey = null;
		$mailService = null;
		$mailListId = null;
		$account = null;
		if(isset($settings["apiKey"])) $apiKey = $settings["apiKey"];
		if(isset($settings["mailService"])) $mailService = $settings["mailService"];
		if(isset($settings["mailListId"])) $mailListId = $settings["mailListId"];
		if(isset($settings["accountName"])) $account = $settings["accountName"];

		$ret = new stdClass();

		if($apiKey != null && $mailService != null && $mailListId != null) {

			if($mailService == 'mailchimp') {
				$api = new MailChimp($apiKey);
				$result = $api->post("lists/".$mailListId."/members", [
					'email_address' => $email,
					'status'        => 'subscribed',
				]);
				if(!$result) {
					$ret->err = json_encode($result);
				}
			} else if($mailService == 'sendinblue') {
				$mailin = new Mailin('https://api.sendinblue.com/v2.0', $apiKey, 5000);
				$data = array( "email"=>$email,
						"listid"=>array($mailListId)
				);

				$retval = $mailin->create_update_user($data);
				if($retval["code"] != 'success') {
					$ret->err = $retval->message;
				}
			} else if($mailService == 'convertkit') {
				$params = explode('|', $mailListId);
				$type = "form";
				$listId = $mailListId;
				if(count($params) == 2) {
					$listId = $params[1];
					$type = $params[0];
				}

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_VERBOSE, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				if($type == "sequence") {
					curl_setopt($ch, CURLOPT_URL, 'https://api.convertkit.com/v3/courses/'.$listId.'/subscribe');
				} else {
					curl_setopt($ch, CURLOPT_URL, 'https://api.convertkit.com/v3/forms/'.$listId.'/subscribe');
				}
				$data = array(
					'api_key' => $apiKey,
					'email' => $email
				);
				$payload = json_encode($data);
				
				// Attach encoded JSON string to the POST fields
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
				
				// Set the content type to application/json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

				$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				$result = curl_exec($ch);
				if(! $result) {
					$ret->err = curl_errno($ch) .': '. curl_error($ch);
				}
				curl_close($ch);				
			}
		} else {
			$ret->err = "Email setting is incorrect";
		}
		return json_encode($ret);
	}
    
    public function postSetting(Request $request)
    {
    	$user = Sentinel::check();
    	if(!$user)
    		return view('login');
    	
    	$code = Code::firstOrCreate(["code_name" => "lang"]);
    	$code->code_value = $request->get('lang');
    	$code->save();

		$code = Code::firstOrCreate(["code_name" => "title"]);
		$code->code_value = $request->get('siteTitle');
		$code->save();

		$code = Code::firstOrCreate(["code_name" => "inlineAdSpot"]);
		$code->code_value = $request->get('inlineAdSpot');
		$code->save();

		$code = Code::firstOrCreate(["code_name" => "belowAdSpot"]);
		$code->code_value = $request->get('belowAdSpot');
		$code->save();

		$code = Code::firstOrCreate(["code_name" => "mailService"]);
		$code->code_value = $request->get('mailService');
		$code->save();

		$code = Code::firstOrCreate(["code_name" => "accountName"]);
		$code->code_value = $request->get('accountName');
		$code->save();

		$code = Code::firstOrCreate(["code_name" => "apiKey"]);
		$code->code_value = $request->get('apiKey');
		$code->save();

		$code = Code::firstOrCreate(["code_name" => "mailListId"]);
		$code->code_value = $request->get('mailListId');
		$code->save();

		return Redirect::route('admin.setting');
    }
    
    public function profile()
    {
    	if(!Sentinel::check())
    		return view('login');
    
    	return view('profile');
    }    
    
    public function postProfile(Request $request)
    {
    	$user = Sentinel::check();
    	if(!$user)
    		return view('login');
    	
    	 $credentials = array(
            'username'    => $user->username,
            'password' => $request->get('currentPassword')
        );
    	 
    	 $result = Sentinel::authenticate($credentials);
    	 if($result) {
    	 	if($request->get('password') != "") {
    	 		$user->password = $request->get('password');
    	 	} else {
    	 		$user->password = $request->get('currentPassword');
    	 	}
    	 	
    	 	if($request->get('email') != "") {
    	 		$user->email = $request->get('email');
    	 	}
    	 	
    	 	if($request->get('username') != "") {
    	 		$user->username = $request->get('username');
    	 	} 
    	 	
    	 	$credentials = array(
    	 			'username'    => $user->username,
    	 			'password' => $user->password
    	 	);
    	 	
    	 	//save photo file
    	 	$attributes = Input::all();
    	 	$fileUrl = null;
    	 	if (isset($attributes['photoImageFile'])) {
    	 		 
    	 		$file = $attributes['photoImageFile'];
    	 		 
    	 		// delete old image
    	 		$destinationPath = public_path() . "/upload/profile";
    	 		$fileName = time().'_'.$file->getClientOriginalName();
    	 		$fileSize = $file->getClientSize();
    	 		$upload_success = $file->move($destinationPath, $fileName);
    	 		 
    	 		if ($upload_success) {
    	 			$fileUrl = "/upload/profile/".$fileName;
    	 			$user->photo = $fileUrl;
    	 		}
    	 	}
    	 	
    	 	Sentinel::update($user, $credentials);    	 	
    	 	Sentinel::authenticate($credentials);
    	 } else {
    	 	//error
    	 	return Redirect::back()->withErrors("Current password does not matched.");
    	 }
    
    	return Redirect::route('admin.logout');
    }
    
    public function getForgotPassword()
    {
    	if(!Sentinel::check())
    		return view('forgot-password');
    
    	return Redirect::route('admin.index');
    }
    
    public function generateRandomString($length = 10) {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
    		$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
    }
    
    public function postForgotPassword(Request $request)
    {
    
    	$credentials = array(
    			'email' => $request->get('email')
    	);
    
    	$rules = array(
    			'email' => 'required|email',
    	);
    
    	$validation = Validator::make($credentials, $rules);
    
    	if($validation->fails())
    	{
    		return Redirect::back()->withErrors($validation)->withInput();
    	}
    
    	// Find the user using the user email address
    	$user = User::where('email', $request->get('email'))->get();
    	
    	if(count($user) == 0)
    	{
    		return Redirect::back()->withErrors("Email account doesn't exist");
    	}
    
    	$user = Sentinel::findUserById($user[0]->id);
    	//$reminderData = Reminder::create($user);
    
    	// Get the password reset code
    	//$resetCode = $reminderData->code;
    	
    	$password = $this->generateRandomString();
    	
    	$user->password = $password;
    	 
    	$credentials = array(
    			'username'    => $user->username,
    			'password' => $user->password
    	);
    	 
    	Sentinel::update($user, $credentials);
    	$email = $request->get('email');
    	 
    	$formData = array('password' => $password, 'email'=> $email, 'username' => $user->username);
    
    	$to      = $email;
    	$subject = 'Reset Password';
    	$message = 'Your changed password is '.$password;
    	$headers = 'From: admin@flashcardscript.com' . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();
    	
    	if(mail($to, $subject, $message, $headers))
    		return Redirect::route('admin.login');
    	else 
    		return Redirect::back()->withErrors(array('forgot-password' => 'Password reset failed'));
    	
    	/*
    	try
    	{
    		Mail::send('emails.password', $formData, function ($message) use ($user) 
    		{
    			$message->from('noreply@flashcard.com', 'Flashcard');
    			$message->to($user->email, $user->username)->subject('Reset Password');
    		});
    
    		return Redirect::route('admin.login');
    	} catch(Exception $ex)
    	{
    		return Redirect::back()->withErrors(array('forgot-password' => 'Password reset failed'));
    	}
    	*/
    	/*$mailer = new Mailer;
    	 $mailer->send('emails.auth.reset-password', 'user@fully.com', 'Reset Password', $formData);*/
    }
    
}
