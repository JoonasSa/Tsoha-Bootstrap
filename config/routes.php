<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/kurssit', function() {
    HelloWorldController::kurssit();
  });

  $routes->get('/kurssi', function() {
    HelloWorldController::kurssi();
  });
  
  $routes->get('/login', function() {
    HelloWorldController::login();
  });
  
  $routes->get('/edit', function() {
    HelloWorldController::edit();
  });