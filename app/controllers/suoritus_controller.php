<?php

class SuoritusController extends BaseController {

    public static function index() {
        if (BaseController::get_is_teacher()) {
            $suoritusjoin = Suoritus::leftJoinToteutusKurssiOppilas();
            View::make('suoritus/suoritukset.html', array('suoritukset' => $suoritusjoin));
        } else {
            Redirect::to('/', array('message' => 'Sinulla ei ole oikeutta päästä tälle sivulle.'));
        }
    }

    public static function my() {
        if (BaseController::get_is_student()) {
            $id = BaseController::get_id();
            $suoritusjoin = Suoritus::findByOppilas($id);
            $opintopisteet = Oppilas::get_op($id);
            View::make('suoritus/my.html', array('suoritukset' => $suoritusjoin, 'opintopisteet' => $opintopisteet));
        } else {
            Redirect::to('/', array('message' => 'Sinulla ei ole oikeutta päästä tälle sivulle.'));
        }
    }

    public static function create($tote_id) {
        $oppilaat = self::generateOppilaatArray($tote_id);
        $tote = Toteutus::oneLeftJoinKurssiOpe($tote_id);
        View::make("suoritus/new.html", array('tote' => $tote, 'arvosana' => array(1, 2, 3, 4, 5), 'suorittajat' => $oppilaat));
    }

    public static function store() {
        if (isset($_POST) && count($_POST)) {
            $_SESSION['post'] = $_POST;
        }
        if (isset($_SESSION['post']) && count($_SESSION['post'])) {
            $_POST = $_SESSION['post'];
        }
        $params = $_POST;

        $suorittaja = null;
        $arvosana = null;
        $pvm = null;
        //EI PALAUTA testi variableja
        $errors = self::getErrors($suorittaja, $arvosana, $pvm, $params);
        if (count($errors) == 0) {
            self::save($params);
        }
        View::make('suoritus/new.html', array('errors' => $errors, 'tote' => Toteutus::oneLeftJoinKurssiOpe($params['tote_id']),
            'arvosana' => array(1, 2, 3, 4, 5), 'suorittajat' => self::generateOppilaatArray($params['tote_id']),
            'selected_arvosana' => $arvosana, 'selected_pvm' => $pvm, 'selected_suorittaja' => $suorittaja));
    }

    private static function save($params) {
        $suoritus = new Suoritus($attributes = array(
            'tote_id' => $params['tote_id'],
            'pvm' => $params['pvm'],
            'arvosana' => $params['arvosana'],
            'suorittaja' => $params['suorittaja']
        ));
        $suoritus->save();
        $_SESSION['post'] = null;
        Redirect::to('/suoritus/suoritukset', array('message' => 'Suoritus on lisätty tietokantaan.'));
    }

    private static function getErrors($suorittaja, $arvosana, $pvm, $params) {
        Kint::dump($params);
        $errors = array();
        if (!isset($params['suorittaja'])) {
            $errors[] = "Täytä oppilaan tiedot!";
        } else {
            $suorittaja = $params['suorittaja'];
        }
        if (!isset($params['arvosana'])) {
            $errors[] = "Täytä arvosana tiedot!";
        } else {
            $arvosana = $params['arvosana'];
            $errors = BaseModel::validate_number("Arvosana", $params['arvosana'], 0, 5, $errors);
        }
        if (strlen($params['pvm']) == 0) {
            $errors[] = "Täytä päivämäärä tiedot!";
        } else {
            $pvm = $params['pvm'];
            $errors = BaseModel::validateDate($params['pvm'], "Päivämäärä", $errors);
        }
        return $errors;
    }

    private static function generateOppilaatArray($tote_id) {
        $ilmot = Ilmoittautuminen::findByToteutus($tote_id);
        $oppilaat = array();
        foreach ($ilmot as $ilmo) {
            if (!Suoritus::getIsGraded($tote_id, $ilmo->ilmoittautuja)) {
                $oppilaat[] = Oppilas::find($ilmo->ilmoittautuja);
            }
        }
        return $oppilaat;
    }

    public static function destroy($tote_id, $suorittaja) {
        $suoritus = new Suoritus(array('tote_id' => $tote_id, 'suorittaja' => $suorittaja));
        $suoritus->destroy();
        Redirect::to('/suoritus/suoritukset', array('message' => 'Suoritus on poistettu onnistuneesti!'));
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
