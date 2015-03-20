<?php 

use Carbon\Carbon;

class PostController extends BaseController {

	public $restful = true;


	public function getPosts(){

		$responseArray = array();

		$userInterests = UserModel::find(Auth::id())->interests()->lists('interest_id');

		//return Response::json($userInterests);

		$posts = PostModel::whereHas('interests', function($q) use($userInterests){

			$q->whereIn('interest_id', $userInterests);
			
		})->latest()->get();
		
		foreach ($posts as $post) {
				
			$user = $post->user;
			
			array_push($responseArray, array('id' => $post->id, 'firstname' => $user->firstname, 'lastname' => $user->lastname, 'username' => $user->username,'photo' => $user->photo , 'body' => $post->body,'date' => $post->created_at->diffForHumans(), 'likes' => $post->likes ,  'tags'=> $post->interests));
				
		}

		ksort($responseArray);

		
		return Response::json($responseArray);

	}

	public function createPost(){

		$pusher = new Pusher('5e626c3d73ef818ae7d9','37622eae078aa88398c1','112140');

		$pusher->trigger('postChannel', 'userCreatedPost', []);


		$input = Input::get('interests');

		$posts = new PostModel;
		$posts->user_id = Auth::user()->id;
		$posts->body = Input::get('body');
		$posts->save();


		foreach ($input as $interest) {
						
			$posts->interests()->attach(InterestModel::findByNameOrFail($interest['text'])->id);
						
		}
		


		return Response::json(Input::all());
	}


	public function addLike(){

		$pusher = new Pusher('5e626c3d73ef818ae7d9','37622eae078aa88398c1','112140');

		$post = PostModel::find(Input::get('id'));
		$post->increment('likes');

		$pusher->trigger('postChannel', 'postUpdated', []);

		return "Incremented!";

	}

	public function addDislike(){

		$pusher = new Pusher('5e626c3d73ef818ae7d9','37622eae078aa88398c1','112140');

		$post = PostModel::find(Input::get('id'));

		if($post->likes > 0) {
			$post->decrement('likes');
			$pusher->trigger('postChannel', 'postUpdated', []);
		}else {

			return "Too Low Cant Go Below 0";

		}
		

		
		return "Incremented!";

	}

}