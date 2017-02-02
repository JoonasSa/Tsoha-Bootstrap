<?php

class HelloWorldController extends BaseController {

    public static function index() {
        View::make('home.html');
    }

    public static function login() {
        View::make('login.html');
    }
    
    public static function edit() {
        View::make('edit.html');
    }

    public static function sandbox() {
        $a = Opettaja::find(1);
        $b = Opettaja::all();
        
        Kint::dump($a);
        Kint::dump($b);
        View::make('hiekkalaatikko.html');
    }

}
