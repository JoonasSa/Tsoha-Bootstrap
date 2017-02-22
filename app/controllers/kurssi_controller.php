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

    public static function edit($id) {
        $kurssi = Kurssi::find($id);
        View::make("kurssi/edit.html", array('kurssi' => $kurssi));
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
        
        $errors = KurssiController::getErrors($params, $kurssi);
        if (count($errors) == 0) {
            $kurssi->save();
            Redirect::to('/kurssi/show/' . $kurssi->kurssi_id, array('message' => 'Kurssi on lisätty tietokantaan.'));
        } else {
            View::make('kurssi/new.html', array('errors' => $errors, 'kurssi' => $params));
        }
    }

    public static function update($kurssi_id) {
        if(isset($_POST) && count($_POST)) { $_SESSION['post'] = $_POST; }
        if(isset($_SESSION['post']) && count($_SESSION['post'])) { $_POST = $_SESSION['post']; }
        $params = $_POST;
        
        $attributes = array(
            'kurssi_id' => $kurssi_id,
            'nimi' => $params['nimi'],
            'opintopisteet' => $params['opintopisteet'],
            'kuvaus' => $params['kuvaus']
        );

        $kurssi = new Kurssi($attributes);
        $errors = KurssiController::getErrors($params, $kurssi);
        if (count($errors) == 0) {
            $kurssi->update();
            $_SESSION['post'] = null;
            Redirect::to('/kurssi/show/' . $kurssi_id, array('message' => 'Kurssia on muokattu onnistuneesti!'));
        } else {
            View::make('/kurssi/edit.html', array('errors' => $errors, 'kurssi' => $attributes));
        }         
    }

    public static function destroy($kurssi_id) {
        $kurssi = new Kurssi(array('kurssi_id' => $kurssi_id));
        $kurssi->destroy();
        Redirect::to('/kurssi/kurssit', array('message' => 'Kurssi on poistettu onnistuneesti!'));
    }

    private static function getErrors($params, $kurssi) {
        $errors = array();
        $errors = $kurssi->validate_string("nimi", $params['nimi'], 3, 60, $errors);
        $errors = $kurssi->validate_number("opintopisteet", $params['opintopisteet'], 1, 25, $errors);
        return $errors;
    }
}