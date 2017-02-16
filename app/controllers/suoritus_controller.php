<?php

class SuoritusController extends BaseController {

    public static function index() {
        $suoritukset = Suoritus::all();
        View::make('suoritus/suoritukset.html', array('srtus' => $suoritukset));
    }
    
    public static function showByToteutus($id) {
        $suoritukset = Suoritus::findByToteutus($id);
        View::make('suoritus/show.html', array('srtus' => $suoritukset));
    }
    
    public static function showByOppilas($id) {
        $suoritukset = Suoritus::findByOppilas($id);
        View::make('suoritus/show.html', array('srtus' => $suoritukset));
    }
    
    public static function showByOppilasAndToteutus($id1, $id2) {
        $suoritukset = Suoritus::findByOppilasAndToteutus($id1, $id2);
        View::make('suoritus/show.html', array('srtus' => $suoritukset));
    }

}