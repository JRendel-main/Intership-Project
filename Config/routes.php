<?php

  Router::connect('/', array(
    'controller' => 'main',
    'action'     => 'index',
  ));

  Router::connect('/login', array(
    'controller' => 'main',
    'action' => 'login',
  ));

  Router::connect('/logout', array(
    'controller' => 'main',
    'action'     => 'logout'
  ));

    // api resources
    $resources = array(
      'users','select',
      'assigns', 'names', 'suppliers', 'shipments', 'equips', 'trucks',
      'cruds', 'beneficiaries', 'print'
    );

  Router::mapResources($resources, array('prefix' => 'api'));
  Router::parseExtensions('json');

CakePlugin::routes();
require CAKE . 'Config' . DS . 'routes.php';
