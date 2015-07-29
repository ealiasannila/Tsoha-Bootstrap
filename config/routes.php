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
  $routes->get('/newtopic/reply', function() {
    HelloWorldController::newReply();
  });
  $routes->get('/subforum', function() {
    HelloWorldController::subForum();
  });
  $routes->get('/forum', function() {
    HelloWorldController::forum();
  });
