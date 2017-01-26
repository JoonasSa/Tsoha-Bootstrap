<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
    }

    public static function kurssit() {
        // Testaa koodiasi täällä
        View::make("kurssit.html");
    }

    public static function kurssi() {
        // Testaa koodiasi täällä
        View::make("kurssi.html");
    }

    public static function login() {
        View::make('login.html');
    }
    
    public static function edit() {
        View::make('edit.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make("helloworld.html");
    }

}
