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
        $periodit = array(1, 2, 3, 4, 5);
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

        $errors = self::validateDates($params['alkupvm'], $params['koepvm']);
        if (count($errors) == 0) {
            $toteutus->update();
            Redirect::to('/toteutus/show/' . $toteutus->tote_id, array('message' => 'Toteutusta on muokattu onnistuneesti!'));
        } else {
            //EI VALMIS
            self::edit($id);
            //View::make('toteutus/edit.html', array('errors' => $errors));
        }
    }
    
    public static function destroy($id) {
        $toteutus = new Toteutus(array('tote_id' => $id));
        $toteutus->destroy();
        Redirect::to('/toteutus/toteutukset', array('message' => 'Toteutus on poistettu onnistuneesti!'));
    }
    
    private static function validateDates($alkupvm, $koepvm) {
        $errors = array();
        $d = DateTime::createFromFormat('Y-m-d', $alkupvm);
        if (!($d && $d->format('Y-m-d') === $alkupvm)) {
            $errors[] = $alkupvm . " ei ole muotoa YYYY-MM-DD.";
        }
        $e = DateTime::createFromFormat('Y-m-d', $koepvm);
        if (!($e && $e->format('Y-m-d') === $koepvm)) {
            $errors[] = $koepvm . " ei ole muotoa YYYY-MM-DD.";
        }
        return $errors;
    }

}
