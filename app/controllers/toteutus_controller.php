<?php

class ToteutusController extends BaseController {
    
    public static function index() {
        $toteutukset = Toteutus::all();
        View::make('toteutus/toteutukset.html', array('toteutukset' => $toteutukset));
    }

}