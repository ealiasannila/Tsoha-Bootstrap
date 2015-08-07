<?php

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });
  $routes->get('/register', function() {
    HelloWorldController::register();
  });
  
  $routes->get('/aihealue/:id/uusiaihe', function($id) {
      UusiAiheController::listaa($id);
  });
  $routes->post('/aihealue/:id/uusiaihe', function($id) {
      UusiAiheController::lisaaAihe($id);
  });
  
  $routes->get('/aihe/:id/vastaus', function($id) {
      UusiVastausController::listaa($id);
  });
  $routes->post('/aihe/:id/vastaus', function($id) {
      UusiVastausController::lisaaVastaus($id);
  });
  
  $routes->get('/aihealue/:id', function($id) {
      AihealueController::listaa($id);
  });
  $routes->get('/', function() {
      FoorumiController::listaa();
  });
  
  $routes->get('/aihe/:id', function($id) {
      AiheController::listaa($id);
  });
  $routes->get('/kayttaja/:id', function($id) {
      KayttajaController::listaa($id);
  });

