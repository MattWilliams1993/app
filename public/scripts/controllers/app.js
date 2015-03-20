var app = angular.module('Web', ['ngRoute', 'ngFacebook', 'ngMaterial', 'ngTagsInput', 'angularFileUpload', 'pusher-angular']);


app.config(function($routeProvider, $locationProvider, $facebookProvider, $mdThemingProvider){

	$facebookProvider.setAppId('1614322208780948');

	$routeProvider.when('/', {
		templateUrl: 'views/home.html',
		controller: 'MainCtrl'
	}).when('/user/login', {
		templateUrl: 'views/user/login.html',
		controller: 'LoginCtrl'
	}).when('/user/signup', {
		templateUrl: 'views/user/signup.html',
		controller: 'SignUpCtrl'
	}).when('/step3', {
		templateUrl: 'views/profile/step3.html',
		controller: 'StepCtrl'
	}).when('/step2', {
		templateUrl: 'views/profile/step2.html',
		controller: 'StepCtrl'
	}).when('/app', {
		templateUrl: 'views/user/app.html',
		controller: 'AppCtrl'
	}).when('/us/about', {
		templateUrl: 'views/us/about.html',
		controller: 'AboutCtrl'
	}).when('/:username', {
		templateUrl: 'views/user/profile.html',
		controller: 'ProfileCtrl'
	});


	$locationProvider.html5Mode(true);
});

app.run(function($rootScope) {

	(function(){
	 if (document.getElementById('facebook-jssdk')) {return;}

	 var firstScriptElement = document.getElementsByTagName('script')[0];

     // Create a new script element and set its id
     var facebookJS = document.createElement('script'); 
     facebookJS.id = 'facebook-jssdk';

     // Set the new script's source to the source of the Facebook JS SDK
     facebookJS.src = '//connect.facebook.net/en_US/all.js';

     // Insert the Facebook JS SDK into the DOM
     firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
   }());

});