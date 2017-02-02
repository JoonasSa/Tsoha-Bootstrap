<?php

$routes->get('/', function() {
    IndexController::index();
});

$routes->get('/hiekkalaatikko', function() {
    IndexController::sandbox();
});

$routes->get('/login', function() {
    IndexController::login();
});

$routes->get('/edit', function() {
    IndexController::edit();
});

$routes->get('/kurssi/kurssit', function() {
    KurssiController::index();
});

$routes->get('/kurssi/show/:id', function($id) {
    KurssiController::show($id);
});

$routes->get('/kurssi/new', function() {
    KurssiController::create();
});

$routes->post('/kurssi', function() {
    KurssiController::store();
});

$routes->get('/toteutus/toteutukset', function() {
    ToteutusController::index();
});

$routes->get('/suoritus/suoritukset', function() {
    SuoritusController::index();
});