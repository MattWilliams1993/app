<?php 

class UserController extends BaseController {


	public $restful = true;


	/**
	* Display Listing of the resourse
	* 
	* @Return response
	*
	*/

	public function login(){

		 $userData = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		 	
		 );

		if(Auth::attempt($userData))
		{

				//Get user record in table

				$user = UserModel::find(Auth::user()->id);

				//If user account has completed step 1
				if($user->user_status == 1){

					return "user_status_1";

				}

				if($user->user_status == 2){

					return "user_status_2";
				}

				return "success";

		}//End Auth Attempt
		else{
			
			return "userNotFound";

		}//End
	}


	public function signUpUser() {

		$userData = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
			);

		if(Auth::attempt($userData)) {

			return "account already created. Redirect to app";

		}else{

			$user = new UserModel;

			$user->username = Input::get('username');
			$user->password = Input::get('password');
			$user->email = Input::get('email');
			$user->firstname = Input::get('firstname');
			$user->lastname = Input::get('lastname');
			$user->photo = "img/photo.png";
			$user->pref_language = Input::get('pref_language');
			$user->save();

			return Redirect::to('/user/login');

		}
		


	}

	public function logout() {

		if(Auth::check()){
			
			Auth::logout();
			Session::flush();

			return "loggedOut";
		}else {
			
		}
		

	}

	public function userLogedIn() {

		if(Auth::check()){
			echo "true";
		}else {
			echo "false";
		}
	}

	public function step2Update(){

		if(Input::get('interests')){
			if(Auth::check()){

				$user = UserModel::find(Auth::user()->id);

				$input =  Input::get('interests');

				foreach ($input as $interest) {
						
					$user->interests()->attach(InterestModel::findByNameOrFail($interest['text'])->id);
						
				}

				$user->user_status = 1;
				
				$user->save();

			}
		}else {

			return "error";
		}

		

	}

	public function getUserData() {

		$userId = Auth::id();

		$userData = Auth::user();

		return Response::json(array(
			'firstname' => $userData->firstname, 
			'lastname' => $userData->lastname,
			'username' => $userData->username,
			'photo' => $userData->photo,
			'pref_language' => $userData->pref_language,
			'email' => $userData->email,
			'interests' => UserModel::find($userId)->interests()->get()
			));
	}

	public function getPublicUserData($id) {

		$userId = UserModel::findByUsernameOrFail($id);

		return Response::json(array(
			'givenname' => $userId->givenname, 
			'surname' => $userId->surname,
			'username' => $userId->username,
			'photo' => $userId->photo,
			'pref_language' => $userId->pref_language,
			'email' => $userId->email,
			));
	}

	public function photoUpload() {

		if(Auth::check()){

			if(mkdir('../public/uploads/' . Auth::user()->id))
			{
				if(Input::hasFile('file')){

					Input::file('file')->move('../public/uploads/' . Auth::user()->id , 'profilepicture.png');

					$user = UserModel::find(Auth::user()->id);

					$user->photo = '/uploads/' . Auth::user()->id . '/profilepicture.png';

					$user->user_status = 2;

					$user->save();

					return "success";

				}
				
			}


		}

		


	}

}
