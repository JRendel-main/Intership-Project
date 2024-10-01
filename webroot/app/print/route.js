app.config(function($routeProvider) {
  $routeProvider
  .when('/users', {
    templateUrl: tmp + 'users__index',
    controller: 'UsersController',
  })

});


