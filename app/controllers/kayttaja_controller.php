<?php

class KayttajaController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }
    
    public static function signup() {
        View::make('user/signup.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $user = Kayttaja::authenticate($params['etunimi'], $params['sukunimi'], $params['password']);
        if (!$user) {
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'attributes' => $params));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->username . '!'));
        }
    }

    public static function handle_signup() {
        $params = $_POST;
        //eka pitää luoda uusi oppilas tai opettaja, ja validoida se HUOM! pitää olla uniikki: etunimi + sukunimi + password kombinaatio
        $user = new Kayttaja(array('username' => $params['etunimi'] . ' ' .  $params['sukunimi']));
        $errors = KayttajaController::getErrors($params);
        if (count($errors) == 0) {
            $new = $user->save();
            $_SESSION['user'] = $new->id;
            Redirect::to('/', array('message' => 'Tervetuloa kurssijärjestelmään ' . $new->username . '!'));
        } else {
            View::make('user/signup.html', array('errors' => $errors, 'attributes' => $params));
        }
    }
    
    public static function getErrors($params) {
        $errors = array();
        $errors = BaseModel::validate_string("etunimi", $params['etunimi'], 2, 30, $errors);
        $errors = BaseModel::validate_string("sukunimi", $params['sukunimi'], 2, 30, $errors);
        return $errors;
    }
}
