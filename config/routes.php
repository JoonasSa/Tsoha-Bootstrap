<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/edit', function() {
    HelloWorldController::edit();
});