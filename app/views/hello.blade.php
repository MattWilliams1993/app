<html>
	<head>
			<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.2.2/css/ripples.min.css" rel="stylesheet">
    		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.2.2/css/material-wfont.min.css" rel="stylesheet">
    		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/0.7.0/angular-material.min.css">
    		<link rel="stylesheet" type="text/css" href="http://localhost/css/style.css">
    		<link rel="stylesheet" type="text/css" href="http://localhost/css/ng-tags-input.css">
    		<link rel="stylesheet" type="text/css" href="http://localhost/css/animate.css">
    		<base href="/"/>
        @if(Auth::check())
    		<title>Trendoo</title>
        @else
        <title>Welcome To Trendoo.co | Follow the latest trends LIVE as they happen</title>
        @endif
	</head>
	<body ng-app="Web">	

@if(Auth::check())


<div ng-controller="MainCtrl"> 
		<nav class="navbar navbar-default" style="margin-bottom: 0px;">
      	<div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" ng-href="/app">Trendoo</a>
          </div>

          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li class=""> </li>
              <li class=""></li>
              <li class=""><a href="" ng-click="logout()">Logout</a></li>
              <li class=""><a ng-href="/user/{{ Auth::user()->username }}">Profile</a></li>
            </ul>
          </div><!--/.nav-collapse -->
      </div>
    </nav>
</div>

@else
	<div> 
		<nav class="navbar navbar-default">
      	<div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" ng-href="/">Trendoo</a>
        </div>
        

        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right" style="margin-right: 100px;">
            <li class=""><a href="user/login">Login</a></li>
            <li class=""><a href="/us/about">About</a></li>
          </ul>
          
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    </div>
@endif
<div ng-view=""></div>

	   

<!-- 

Manage these later and merge them into one file for less http requests..

-->


<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular-route.min.js"></script>
<script src="http://hammerjs.github.io/dist/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular-resource.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.2.2/js/ripples.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.2.2/js/material.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.6/angular-animate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angular_material/0.7.0/angular-material.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.6/angular-aria.min.js"></script>
<script src="scripts/angular-file-upload-shim.min.js"></script>
<script src="scripts/angular-file-upload.min.js"></script>
<script src="scripts/ng-tags-input.min.js"></script>
<script src="scripts/ngFacebook.js"></script>
<script src="//js.pusher.com/2.2/pusher.min.js"></script>
<script src="//cdn.jsdelivr.net/angular.pusher/latest/pusher-angular.min.js"></script>
<script src="scripts/controllers/app.js"></script>
<script src="scripts/controllers/main.js"></script>	



</body>
</html>
