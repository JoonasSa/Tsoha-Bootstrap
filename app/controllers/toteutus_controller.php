<?php

class ToteutusController extends BaseController {

    public static function index() {
        if (BaseController::get_is_student()) {
            $array = Ilmoittautuminen::findByOppilas(BaseController::get_id());
            $toteutusjoin = Toteutus::sanitizedLeftJoinKurssiOpe($array);
            View::make('toteutus/toteutukset.html', array('toteutusjoin' => $toteutusjoin));
        } else {
            $toteutusjoin = Toteutus::allLeftJoinKurssiOpe();
            View::make('toteutus/toteutukset.html', array('toteutusjoin' => $toteutusjoin));
        }
    }

    public static function show($id) {
        $toteutusjoin = Toteutus::oneLeftJoinKurssiOpe($id);
        View::make('toteutus/show.html', array('tote' => $toteutusjoin));
    }

    public static function showAll($kurssi_id) {
        $array = Ilmoittautuminen::findByOppilas(BaseController::get_id());
        $totet = Toteutus::sanitizedLeftJoinKurssiOpe($array);
        $toteutusjoin = array();
        foreach ($totet as $tote) {
            if ($tote['kurssi_id'] == $kurssi_id) {
                $toteutusjoin[] = $tote;
            }
        }
        $empty = null;
        if ($toteutusjoin == null) {
            $empty = true;
        }
        View::make('toteutus/showall.html', array('tote' => $toteutusjoin, 'empty' => $empty));
    }

    public static function myOpe() {
        if (BaseController::get_is_teacher()) {
            $toteutusjoin = Toteutus::leftJoinByOpeId(BaseController::get_id());
            View::make('toteutus/my.html', array('toteutusjoin' => $toteutusjoin));
        }
        Redirect::to("/", array('message' => "Vain opettajille."));
    }

    public static function create() {
        $opettajat = Opettaja::all();
        $kurssit = Kurssi::all();
        $periodit = array(1, 2, 3, 4, 5);
        View::make("toteutus/new.html", array('kurssit' => $kurssit, 'opettajat' => $opettajat, 'periodit' => $periodit));
    }

    public static function store() {
        if (isset($_POST) && count($_POST)) {
            $_SESSION['post'] = $_POST;
        }
        if (isset($_SESSION['post']) && count($_SESSION['post'])) {
            $_POST = $_SESSION['post'];
        }
        $params = $_POST;

        $array = self::getErrors($params);

        if (count($array['errors']) == 0) {
            self::save($params);
        } else {
            $attributes = array(
                'periodi' => $array['periodi'],
                'alkupvm' => $params['alkupvm'],
                'koepvm' => $params['koepvm'],
                'info' => $params['info'],
                'vastuu_id' => $array['opettaja'],
                'kurssi_id' => $array['kurssi']
            );
            View::make('toteutus/new.html', array('errors' => $array['errors'], 'tote' => $attributes, 'kurssit' => Kurssi::all(),
                'opettajat' => Opettaja::all(), 'periodit' => array(1, 2, 3, 4, 5), 'selected_kurssi' => $array['kurssi'],
                'selected_opettaja' => $array['opettaja'], 'selected_periodi' => $array['periodi']));
        }
    }

    private static function save($params) {
        $toteutus = new Toteutus(array(
            'periodi' => $params['periodi'],
            'alkupvm' => $params['alkupvm'],
            'koepvm' => $params['koepvm'],
            'info' => $params['info'],
            'vastuu_id' => $params['opettaja'],
            'kurssi_id' => $params['kurssi']
        ));
        $toteutus->save();
        $_SESSION['post'] = null;
        Redirect::to('/toteutus/show/' . $toteutus->tote_id, array('message' => 'Kurssi on lisätty tietokantaan.'));
    }

    public static function edit($id) {
        $tote = Toteutus::oneLeftJoinKurssiOpe($id);
        $opettajat = Opettaja::all();
        $kurssit = Kurssi::all();
        $periodit = array(1, 2, 3, 4, 5);
        View::make('toteutus/edit.html', array('tote' => $tote, 'kurssit' => $kurssit, 'opettajat' => $opettajat, 'periodit' => $periodit));
    }

    public static function update($id) {
        if (isset($_POST) && count($_POST)) {
            $_SESSION['post'] = $_POST;
        }
        if (isset($_SESSION['post']) && count($_SESSION['post'])) {
            $_POST = $_SESSION['post'];
        }
        $params = $_POST;

        $array = self::getErrors($params);

        if (count($array['errors']) == 0) {
            $toteutus = new Toteutus(array(
                'tote_id' => $id,
                'periodi' => $params['periodi'],
                'alkupvm' => $params['alkupvm'],
                'koepvm' => $params['koepvm'],
                'info' => $params['info'],
                'vastuu_id' => $params['opettaja'],
                'kurssi_id' => $params['kurssi']
            ));
            $toteutus->update();
            $_SESSION['post'] = null;
            Redirect::to('/toteutus/show/' . $toteutus->tote_id, array('message' => 'Toteutusta on muokattu onnistuneesti!'));
        } else {
            $attributes = array(
                'tote_id' => $id,
                'periodi' => $array['periodi'],
                'alkupvm' => $params['alkupvm'],
                'koepvm' => $params['koepvm'],
                'info' => $params['info'],
                'vastuu_id' => $array['opettaja'],
                'kurssi_id' => $array['kurssi']
            );
            View::make('toteutus/edit.html', array('errors' => $array['errors'], 'tote' => $attributes, 'kurssit' => Kurssi::all(),
                'opettajat' => Opettaja::all(), 'periodit' => array(1, 2, 3, 4, 5), 'selected_kurssi' => $array['kurssi'],
                'selected_opettaja' => $array['opettaja'], 'selected_periodi' => $array['periodi']));
        }
    }

    private static function getErrors($params) {
        $array = array();
        $array['kurssi'] = null;
        $array['periodi'] = null;
        $array['opettaja'] = null;
        $errors = array();
        $errors = BaseModel::validateDate($params['alkupvm'], "Alkupäivä", $errors);
        $errors = BaseModel::validateDate($params['koepvm'], "Koepäivä", $errors);
        if (!isset($params['kurssi'])) {
            $errors[] = "Täytä kurssi tiedot!";
        } else {
            $array['kurssi'] = $params['kurssi'];
        }
        if (!isset($params['periodi'])) {
            $errors[] = "Täytä periodi tiedot!";
        } else {
            $array['periodi'] = $params['periodi'];
        }
        if (!isset($params['opettaja'])) {
            $errors[] = "Täytä opettaja tiedot!";
        } else {
            $array['opettaja'] = $params['opettaja'];
        }
        $array['errors'] = $errors;
        return $array;
    }

    public static function destroy($id) {
        $toteutus = new Toteutus(array('tote_id' => $id));
        $toteutus->destroy();
        Redirect::to('/toteutus/toteutukset', array('message' => 'Toteutus on poistettu onnistuneesti!'));
    }

}
