<?php

class IlmoController extends BaseController {

    public static function my() {
        if (BaseController::get_user_logged_in()) {
            $id = BaseController::get_id();
            $ilmot = Ilmoittautuminen::leftJoinToteutusKurssiOpettajaByOppilas($id);
            $empty = null;
            if ($ilmot == null) {
                $empty = true;
            }
            View::make("/ilmoittautuminen/my.html", array('empty' => $empty, 'ilmot' => $ilmot));
        }
        Redirect::to("/", array('error' => "Vain oppilaille!"));
    }

    public static function store($id) {
        if (BaseController::get_is_student()) {
            $vanhat_ilmot = Ilmoittautuminen::findByOppilas(BaseController::get_id());
            foreach ($vanhat_ilmot as $ilmo) {
                if ($ilmo->tote_id == $id) {
                    Redirect::to("/toteutus/toteutukset", array('message' => "Olet jo ilmoittautunut tälle kurssille!"));
                }
            }
            $ilmo = new Ilmoittautuminen(array(
                'ilmoittautuja' => BaseController::get_id(),
                'tote_id' => $id));
            //errors
            $ilmo->save();
            Redirect::to("/toteutus/toteutukset", array('message' => "Ilmoittauduttu kurssille!"));
        }
        Redirect::to("/", array('message' => "Vain oppilaille!"));
    }
    
    public static function destroy($tote_id, $ilmoittautuja) {
        $ilmo = new Ilmoittautuminen(array('tote_id' => $tote_id, 'ilmoittautuja' => $ilmoittautuja));
        $ilmo->destroy();
        Redirect::to("/ilmoittautuminen/my", array('message' => 'Toteutus on poistettu onnistuneesti!'));
    }

}
