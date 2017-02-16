<?php

$routes->get('/', function() {
    IndexController::index();
});

$routes->get('/hiekkalaatikko', function() {
    IndexController::sandbox();
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

$routes->get('/kurssi/:id/edit', function($id) {
    KurssiController::edit($id);
});

$routes->post('/kurssi/:id/edit', function($id) {
    KurssiController::update($id);
});

$routes->post('/kurssi/:id/destroy', function($id) {
    KurssiController::destroy($id);
});

$routes->post('/kurssi', function() {
    KurssiController::store();
});

$routes->get('/toteutus/toteutukset', function() {
    ToteutusController::index();
});

$routes->get('/toteutus/show/:id', function($id) {
    ToteutusController::show($id);
});

$routes->get('/suoritus/suoritukset', function() {
    SuoritusController::index();
});

$routes->get('/user/login', function() {
    KayttajaController::login();
});

$routes->post('/user/login', function() {
    KayttajaController::handle_login();
});

$routes->get('/user/signup', function() {
    KayttajaController::signup();
});

$routes->post('/user/signup', function() {
    KayttajaController::handle_signup();
});

$routes->post('/user/logout', function() {
    KayttajaController::handle_logout();
});

$routes->get('/user/all', function() {
    KayttajaController::index();
});