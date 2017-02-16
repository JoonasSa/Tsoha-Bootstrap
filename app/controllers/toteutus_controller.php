<?php

class ToteutusController extends BaseController {
    
    public static function index() {
        $toteutusjoin = Toteutus::allLeftJoinKurssiOpe();
        View::make('toteutus/toteutukset.html', array('toteutusjoin' => $toteutusjoin));
    }
    
    public static function show($id) {
        $toteutusjoin = Toteutus::oneLeftJoinKurssiOpe($id);
        View::make('toteutus/show.html', array('tote' => $toteutusjoin));
    }
    
    public static function edit($id) {
        $toteutusjoin = Toteutus::oneLeftJoinKurssiOpe($id);
        $opettajat = Opettaja::all();
        $kurssit = Kurssi::all();
        $periodit = array(1,2,3,4,5);
        View::make('toteutus/edit.html', array('toteutusjoin' => $toteutusjoin, 'kurssit' => $kurssit, 'opettajat' => $opettajat, 'periodit' => $periodit));
    }

    public static function update($id) {
        $params = $_POST;
        
        $toteutus = new Toteutus(array(
            'tote_id' => $id,
            'periodi' => $params['periodi'],
            'alkupvm' => $params['alkupvm'],
            'koepvm' => $params['koepvm'],
            'info' => $params['info'],
            'vastuu_id' => $params['opettaja'],
            'kurssi_id' => $params['kurssi']
        ));

        //$errors = KurssiController::getErrors($params, $kurssi);
        //if (count($errors) == 0) {
            $toteutus->update();
            Redirect::to('/toteutus/show/' . $toteutus->tote_id, array('message' => 'Toteutusta on muokattu onnistuneesti!'));
        /* } else {
            //Bugi: kadottaa kurssi_id:n tokan update virheen jälkeen
            View::make('kurssi/edit.html', array('errors' => $errors, 'kurssi' => $params, 'id' => $kurssi_id));
        }  */       
    }
}