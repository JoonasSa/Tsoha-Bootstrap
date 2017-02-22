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
    
    public static function show($id) {
        $user = BaseController::get_user_logged_in();
        if ($user && $user->id == $id) {
                $suoritusjoin = Suoritus::leftJoinToteutusKurssiOppilas();
                View::make('suoritus/suoritukset.html', array('suoritukset' => $suoritusjoin));
        } else {
            Redirect::to('/', array('message' => 'Sinulla ei ole oikeutta päästä tälle sivulle.'));
        }
    }

    public static function create() {
        $oppilaat = Oppilas::all();
        $toteutukset = Toteutus::all();
        View::make("suoritus/new.html", array('oppilaat' => $oppilaat, 'toteutukset' => $toteutukset));
    }

    public static function store() {
        $params = $_POST;
        $suoritus = new Suoritus(array(
            'tote_id' => $params['tote_id'],
            'pvm' => $params['pvm'],
            'arvosana' => $params['arvosana'],
            'suorittaja' => $params['suorittaja']
        ));

        $errors = BaseModel::validateDate($params['pvm'], "Päivämäärä", array());
        if (count($errors) == 0) {
            $suoritus->save();
            Redirect::to('/suoritus/suoritukset/', array('message' => 'Suoritus on lisätty tietokantaan.'));
        } else {
            View::make('suoritus/new.html', array('errors' => $errors, 'suoritus' => $params));
        }
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
