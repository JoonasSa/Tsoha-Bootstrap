<?php

class IndexController extends BaseController {

    public static function index() {
        View::make('home.html');
    }
    
    public static function edit() {
        View::make('edit.html');
    }

    public static function sandbox() {
        $a = $_SESSION['user'];
        //$c = $a->id;
        $b = Kayttaja::find($a);
        
        Kint::dump($a);
        Kint::dump($b);
        //Kint::dump($c);
        View::make('hiekkalaatikko.html');
    }

}
