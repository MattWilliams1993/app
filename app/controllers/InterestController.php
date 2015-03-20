<?php 

class InterestController extends BaseController {

	public $restful = true;


	public function getInterest()
	{	

		$query = Input::get('q');

		$search = InterestModel::where('name', 'LIKE', '%'. Input::get('q'). '%')->get();

		$response = array();

		foreach($search as $result){

			
				$interestName = $result->name;

				array_push($response, array('text' => $interestName));	
		}

		return $response;
	}

	public function addtag(){


		$input = Input::get('tag');
		$tagName = $input['text'];


		if(InterestModel::findByNameOrFail($tagName)) {

			return "Tag Already Created";

		}else {	

			
			$newTag = new InterestModel;
			$newTag->name = $tagName;
			$newTag->save();

			return "created new tag";

		}

		
	}

}
