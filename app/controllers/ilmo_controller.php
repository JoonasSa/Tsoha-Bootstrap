<?php

class IlmoController extends BaseController {

    public static function my() {
        if (BaseController::get_user_logged_in()) {
            $id = BaseController::get_id();
            $ilmot = Ilmoittautuminen::leftJoinToteutusKurssiOpettajaByOppilas($id);
            View::make("/ilmoittautumiset/my.html", array('ilmot' => $ilmot));
        }
        Redirect::to("/", array('message' => "Vain sisäänkirjautuneille käyttäjille!"));
    }

}
