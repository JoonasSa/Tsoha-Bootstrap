<?php

class ToteutusController extends BaseController {
    
    public static function index() {
        $toteutusjoin = Toteutus::allLeftJoinKurssiOpe();
        View::make('toteutus/toteutukset.html', array('toteutusjoin' => $toteutusjoin));
    }

    public static function show($id) {
        $toteutusjoin = Toteutus::oneLeftJoinKurssiOpe($id);
        Kint::dump($toteutusjoin);
        View::make('toteutus/show.html', array('tote' => $toteutusjoin));
    }
}