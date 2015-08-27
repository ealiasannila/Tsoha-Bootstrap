<?php

function tarkistaKirjautuminen(){
    BaseController::check_logged_in();
}


$routes->post('/haku', function() {
    VastausController::hae();
});


$routes->get('/aihealue/:id/uusiaihe', 'tarkistaKirjautuminen', function($id) {
    AiheController::naytaLisays($id);
});
$routes->post('/aihealue/:id/uusiaihe', 'tarkistaKirjautuminen', function($id) {
    AiheController::lisaaAihe($id);
});

$routes->get('/aihe/:id/vastaus','tarkistaKirjautuminen', function($id) {
    VastausController::naytaLisays($id);
});
$routes->post('/aihe/:id/vastaus','tarkistaKirjautuminen', function($id) {
    VastausController::lisaaVastaus($id);
});


$routes->get('/vastaus/:id/muokkaa','tarkistaKirjautuminen', function($id) {
    VastausController::naytaMuokkaus($id);
});
$routes->post('/vastaus/:id/muokkaa','tarkistaKirjautuminen', function($id) {
    VastausController::muokkaaVatausta($id);
});
$routes->get('/vastaus/:id/poista','tarkistaKirjautuminen', function($id) {
    VastausController::poista($id);
});


$routes->get('/aihealue/:id/muokkaa','tarkistaKirjautuminen', function($id) {
    AihealueController::naytaMuokkaus($id);
});
$routes->post('/aihealue/:id/muokkaa','tarkistaKirjautuminen', function($id) {
    AihealueController::muokkaa($id);
});
$routes->get('/aihealue/:id/poista','tarkistaKirjautuminen', function($id) {
    AihealueController::poista($id);
});
$routes->get('/aihealue/:id', function($id) {
    AihealueController::nayta($id);
});

$routes->get('/', function() {
    AihealueController::listaa();
});

$routes->get('/aihe/:id', function($id) {
    AiheController::listaa($id);
});
$routes->get('/kayttaja/:id', function($id) {
    kayttajaController::listaa($id);
});


$routes->get('/kayttajaryhma/:id', function($id) {
    KayttajaRyhmaController::nayta($id);
});
$routes->post('/kayttajaryhma/:ryhmaid/lisaajasen/', function($ryhmaid) {
    KayttajaRyhmaController::lisaaJasen($ryhmaid);
});
$routes->post('/kayttajaryhma/:ryhmaid/poistajasen/', function($ryhmaid) {
    KayttajaRyhmaController::poistaJasen($ryhmaid);
});


$routes->get('/ryhmahallinta', function() {
    KayttajaRyhmaController::listaa();
});
$routes->post('/ryhmahallinta/uusiryhma', function() {
    KayttajaRyhmaController::lisaaRyhma();
});
$routes->post('/ryhmahallinta/poistaryhma', function() {
    KayttajaRyhmaController::poistaRyhma();
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
$routes->get('/rekisteroidy', function() {
    kayttajaController::naytaRekisteroityminen();
});
$routes->post('/rekisteroidy', function() {
    kayttajaController::rekisteroidy();
});


$routes->post('/uusiaihealue','tarkistaKirjautuminen', function() {
    AihealueController::lisaaAihealue();
});
$routes->get('/uusiaihealue','tarkistaKirjautuminen', function() {
    AihealueController::naytaLisays();
});

