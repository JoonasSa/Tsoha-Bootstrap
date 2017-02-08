<?php

class IndexController extends BaseController {

    public static function index() {
        View::make('home.html');
    }
    
    public static function edit() {
        View::make('edit.html');
    }

    public static function sandbox() {
        $b = Suoritus::all();
        $c = Suoritus::findByOppilas(1);
        $d = Suoritus::findByToteutus(1);
        $e = Suoritus::findByOppilasAndToteutus(1, 1);
        
        Kint::dump($b);
        Kint::dump($c);
        Kint::dump($d);
        Kint::dump($e);
        View::make('hiekkalaatikko.html');
    }

}
