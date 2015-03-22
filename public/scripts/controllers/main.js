/**

	Main Controller is for the "Home Page" as in not logged in first visit. Should be renamed but meh.

**/


app.controller('MainCtrl', ['$scope', '$http', '$facebook', function($scope, $http, $facebook){


	$scope.isLoggedIn = false;

	$scope.login = function() {
		$facebook.login().then(function(){
			refresh();
		})
	}

	function refresh(){
		$facebook.api('/me').then(function(response){

			var tempUserData = response;

			var temp = response.first_name + '' + response.last_name + '' + response.id;

			$http.post('api/user/signup', {username: response.id, firstname: response.first_name, lastname: response.last_name, email: response.email, password: temp , pref_language: "not set yet"}).success(function(data){

				console.log(tempUserData.id, temp);

				$http.post('api/user/login', {username: response.id, password: temp}).success(function(data){

					console.log(data);

					if(data == "success"){
						window.location.href = "/step2";
					}

					if(data == "user_status_1"){

						window.location.href = "/step3";
					}

					if(data == "user_status_2"){

						window.location.href = "/app";
					}

				});

			});
		})
	}

	$scope.signUpUser = function() {

	//Form validation goes here shit head

		$http.post('api/user/signup', {username: $scope.user.username, firstname: $scope.user.firstname, lastname: $scope.user.lastname, email: $scope.user.email, password: $scope.user.password, pref_language: $scope.user.pref_language}).success(function(data){

			window.location.href = "user/login";

		});


	};


	$scope.logout = function() {

		$http.post('api/user/logout').success(function(data){

			if(data == "loggedOut"){

				$facebook.logout();
				window.location.href = "/";
			}

		});


	}

	
}]);

/**

	Log In Contoller handles both Facebook login's and normal user logins, could do with a bit of cleaning up.

**/


app.controller('LoginCtrl', ['$scope', '$http', '$facebook', function($scope, $http, $facebook){

$scope.login = function() {
		$facebook.login().then(function(){
			refresh();
		})
	}


	function refresh(){
		$facebook.api('/me').then(function(response){

			var tempUserData = response;

			var temp = response.first_name + '' + response.last_name + '' + response.id;

			$http.post('api/user/signup', {username: response.id, firstname: response.first_name, lastname: response.last_name, email: response.email, password: temp , pref_language: "not set yet"}).success(function(data){

				console.log(tempUserData.id, temp);

				$http.post('api/user/login', {username: response.id, password: temp}).success(function(data){

					console.log(data);

					if(data == "success"){
						window.location.href = "/step2";
					}

					if(data == "user_status_1"){

						window.location.href = "/step3";
					}
					if(data == "user_status_2"){

						window.location.href = "/app";
					}

				});

			});
		})
	}

$scope.loginUser = function() {

	$http.post('api/user/login', {username: $scope.user.username, password: $scope.user.password}).success(function(data){

		if(data == "success"){

			window.location.href = "/step2";
		}

		if(data == "user_status_1"){

			window.location.href = "/step3";
		}
		if(data == "user_status_2"){

			window.location.href = "/app";
		}

	});

};


}]);

/**

	End of Login Contoller

**/

/**

	Sign Up Controller handles the sign up page.

**/

app.controller('SignUpCtrl', ['$scope', '$http', function($scope, $http){


$scope.signUpUser = function() {

	//Form validation goes here shit head

		$http.post('api/user/signup', {username: $scope.user.username, firstname: $scope.user.firstname, lastname: $scope.user.lastname, email: $scope.user.email, password: $scope.user.password, pref_language: $scope.user.pref_language}).success(function(data){

			window.location.href = "user/login";

		});


	};

}]);

/**

	End of Sign Up Contoller

**/

/**

	Step 2 controller to handle inputs of the users interests, profile picture, etc...

**/
app.controller('StepCtrl', [ '$scope', '$http','$upload', function($scope, $http, $upload){


	$scope.loadItems = function($query){
		return $http.get('api/search/getInterest?q=' + $query);
	}

	$scope.completeStep2 = function() {

		$http.post('api/users/step2Update', {interests: $scope.tags}).success(function(data){

				console.log(data);
				if(data == "error") {

					console.log("No Tags Entered");
					
				}else {

					$scope.clicked = true;
					window.location.href = "/step3";
				}
		});
	}

	$scope.addTag = function($tag){
		$http.post('api/search/addtag', {tag: $tag}).success(function(data){
			console.log(data);
		});
	}

	$scope.$watch('files', function () {
        $scope.upload($scope.files);
    });

    $scope.upload = function (files) {
        if (files && files.length) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                $upload.upload({
                    url: 'api/user/photo',
                    fields: {'username': $scope.username},
                    file: file
                }).progress(function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    console.log('progress: ' + progressPercentage + '% ' + evt.config.file.name);
                }).success(function (data, status, headers, config) {
                    if(data == "success"){

                    	window.location.href = "/app";
                    }
                });
            }
        }
    };


}]);

/**

	End of Step 2 Contoller

**/

/**

	Profile Controller to handle eash users profile page
**/

app.controller('ProfileCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams){


}]);


/**

	End of Profile Contoller

**/

/**

	About page controller. (Not really needed but future proofing in case I want to add extended functionality to the about page)

**/

app.controller('AboutCtrl', ['$scope', function($scope){

}]);

/**

	End of About Contoller

**/

/**

	App Controller handles everything that happens inside of /app , here I will add most of the functionality of the site.

**/

app.controller('AppCtrl', ['$scope', '$http', '$pusher',  function($scope, $http, $pusher){
	
	var client = new Pusher('5e626c3d73ef818ae7d9');
	var pusher = $pusher(client);

	pusher.subscribe('postChannel');

	pusher.bind('userCreatedPost', function(data){


		$scope.updatePosts();

	});

	pusher.bind('postUpdated', function(data){


		$scope.updatePosts();

	});


	$scope.loadItems = function($query){
		return $http.get('api/search/getInterest?q=' + $query);
	}
	$http.get('api/user/getUserData').success(function(data){

		$scope.firstname = data.firstname;
		$scope.lastname = data.lastname;
		$scope.photo = data.photo;
		$scope.username = data.username;
		$scope.interests = data.interests
		$scope.updatePosts();

	});

	$scope.updatePosts = function() {

		$http.get('api/post/getPosts').success(function(data){

			console.log(data);
			$scope.posts = data;

		});
	}

	$scope.postStatus = function(){

		$http.post('api/post/create', {username: $scope.username, body: $scope.bodyContent, interests: $scope.tags }).success(function(data){

			$scope.postContent = $scope.bodyContent;
			$scope.bodyContent = "";	
			$scope.tags = "";

			console.log(data);

		});

	}


	$scope.addLikeToPost = function(postId){

		$http.post('api/post/addLike', {id: postId}).success(function(data){

			//$scope.updatePosts();

		});

	
	}

	$scope.addDislikeToPost = function(postId){

		$http.post('api/post/addDislike', {id: postId}).success(function(data){

			

		});

	
	}


}]);

/**

	End of App Contoller

**/