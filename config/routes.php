<?php


$routes->get('/aihealue/:id/uusiaihe', function($id) {
    AiheController::naytaLisays($id);
});
$routes->post('/aihealue/:id/uusiaihe', function($id) {
    AiheController::lisaaAihe($id);
});

$routes->get('/aihe/:id/vastaus', function($id) {
    VastausController::listaa($id);
});
$routes->post('/aihe/:id/vastaus', function($id) {
    VastausController::lisaaVastaus($id);
});


$routes->get('/vastaus/:id/muokkaa', function($id) {
    VastausController::naytaMuokkaus($id);
});
$routes->post('/vastaus/:id/muokkaa', function($id) {
    VastausController::muokkaaVatausta($id);
});
$routes->get('/vastaus/:id/poista', function($id) {
    VastausController::poista($id);
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
    kayttajaController::listaa($id);
});

$routes->get('/kirjaudu', function() {
    kayttajaController::naytaKirjautuminen();
});
$routes->post('/kirjaudu', function() {
    kayttajaController::teeKirjautuminen();
});
$routes->post('/kirjaudu_ulos', function() {
    kayttajaController::kirjauduUlos();
});

$routes->post('/uusiaihealue', function() {
    AihealueController::lisaaAihealue();
});
$routes->get('/uusiaihealue', function() {
    AihealueController::naytaLisays();
});

