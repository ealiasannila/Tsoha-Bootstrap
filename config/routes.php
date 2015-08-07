<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });
  $routes->get('/register', function() {
    HelloWorldController::register();
  });
  $routes->get('/newtopic', function() {
    HelloWorldController::newTopic();
  });
  $routes->get('/topic/reply', function() {
    HelloWorldController::newReply();
  });
  $routes->get('/aihealue', function() {
      AihealueController::listaa();
  });
  $routes->get('/foorumi', function() {
      FoorumiController::listaa();
  });
  
  $routes->get('/aihe', function() {
      AiheController::listaa();
  });
  $routes->get('/kayttaja', function() {
      KayttajaController::listaa();
  });

