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
    
    public static function create() {
        $opettajat = Opettaja::all();    
        $kurssit = Kurssi::all();
        $periodit = array(1, 2, 3, 4, 5);
        View::make("toteutus/new.html", array('kurssit' => $kurssit, 'opettajat' => $opettajat, 'periodit' => $periodit));
    }
    
    public static function store() {
        if(isset($_POST) && count($_POST)) { $_SESSION['post'] = $_POST; }
        if(isset($_SESSION['post']) && count($_SESSION['post'])) { $_POST = $_SESSION['post']; }
        $params = $_POST;

        $attributes = array(
            'periodi' => $params['periodi'],
            'alkupvm' => $params['alkupvm'],
            'koepvm' => $params['koepvm'],
            'info' => $params['info'],
            'vastuu_id' => $params['opettaja'],
            'kurssi_id' => $params['kurssi']
        );

        $errors = array();
        $errors = BaseModel::validateDate($params['alkupvm'], "Alkupäivä", $errors);
        $errors = BaseModel::validateDate($params['koepvm'], "Koepäivä", $errors);
        if (count($errors) == 0) {
            $toteutus = new Toteutus($attributes);
            $toteutus->save();
            Redirect::to('/toteutus/show/' . $toteutus->tote_id, array('message' => 'Kurssi on lisätty tietokantaan.'));
        } else {
            View::make('toteutus/new.html', array('errors' => $errors, 'tote' => $attributes, 'kurssit' => Kurssi::all(),
                'opettajat' => Opettaja::all(), 'periodit' => array(1,2,3,4,5), 'selected_kurssi' => $params['kurssi'],
                'selected_opettaja' => $params['opettaja'], 'selected_periodi' => $params['periodi']));
        }
    }

    public static function edit($id) {
        $tote = Toteutus::oneLeftJoinKurssiOpe($id);
        $opettajat = Opettaja::all();
        $kurssit = Kurssi::all();
        $periodit = array(1, 2, 3, 4, 5);
        View::make('toteutus/edit.html', array('tote' => $tote, 'kurssit' => $kurssit, 'opettajat' => $opettajat, 'periodit' => $periodit));
    }

    public static function update($id) {
        Kint::dump($_POST);
        if(isset($_POST) && count($_POST)) { $_SESSION['post'] = $_POST; }
        if(isset($_SESSION['post']) && count($_SESSION['post'])) { $_POST = $_SESSION['post']; }
        $params = $_POST;

        $attributes = array(
            'tote_id' => $id,
            'periodi' => $params['periodi'],
            'alkupvm' => $params['alkupvm'],
            'koepvm' => $params['koepvm'],
            'info' => $params['info'],
            'vastuu_id' => $params['opettaja'],
            'kurssi_id' => $params['kurssi']
        );

        $errors = array();
        $errors = BaseModel::validateDate($params['alkupvm'], "Alkupäivä", $errors);
        $errors = BaseModel::validateDate($params['koepvm'], "Koepäivä", $errors);
        if (count($errors) == 0) {
            $toteutus = new Toteutus($attributes);
            $toteutus->update();
            $_SESSION['post'] = null;
            Redirect::to('/toteutus/show/' . $toteutus->tote_id, array('message' => 'Toteutusta on muokattu onnistuneesti!'));
        } else {
            View::make('toteutus/edit.html', array('errors' => $errors, 'tote' => $attributes, 'kurssit' => Kurssi::all(),
                'opettajat' => Opettaja::all(), 'periodit' => array(1,2,3,4,5), 'selected_kurssi' => $params['kurssi'],
                'selected_opettaja' => $params['opettaja'], 'selected_periodi' => $params['periodi']));
        }
    }
    
    public static function destroy($id) {
        $toteutus = new Toteutus(array('tote_id' => $id));
        $toteutus->destroy();
        Redirect::to('/toteutus/toteutukset', array('message' => 'Toteutus on poistettu onnistuneesti!'));
    }

}