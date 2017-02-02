<?php

class KurssiController extends BaseController {

    public static function index() {
        $kurssit = Kurssi::all();
        View::make('kurssi/kurssit.html', array('kurssit' => $kurssit));
    }

    public static function show($id) {
        $kurssi = Kurssi::find($id);
        View::make("kurssi/show.html", array('kurssi' => $kurssi));
    }

    public static function create() {
        View::make("kurssi/new.html");
    }

    public static function store() {
        $params = $_POST;

        $kurssi = new Kurssi(array(
            'nimi' => $params['nimi'],
            'opintopisteet' => $params['opintopisteet'],
            'kuvaus' => $params['kuvaus']
        ));
        $kurssi->save();
        
        Redirect::to('/kurssi/show/' . $kurssi->kurssi_id, array('message' => 'Kurssi on lisätty tietokantaan.'));
    }

}