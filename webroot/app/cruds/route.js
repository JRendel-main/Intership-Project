app.config(function($routeProvider) {
  $routeProvider
  .when('/crud', {
    templateUrl: tmp + 'cruds__index',
    controller: 'CrudsController',
  })

    .when('/crud/add', {
      templateUrl: tmp + 'cruds__add',
      controller: 'CrudsAddController',
    })

    .when('/crud/edit/:id', {
      templateUrl: tmp + 'cruds__edit',
      controller: 'CrudEditController',
    })

    .when('/crud/view/:id/', {
      templateUrl: tmp + 'cruds__view',
      controller: 'CrudViewController',
    })
  ;

});


