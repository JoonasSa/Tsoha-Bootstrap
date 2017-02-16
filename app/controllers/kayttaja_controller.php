<?php

class KayttajaController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }

    public static function signup() {
        View::make('user/signup.html');
    }

    public static function index() {
        if (BaseController::check_logged_in() && BaseController::is_admin()) {
            $kayttajat = Kayttaja::all();
            View::make('user/all.html', array('users' => $kayttajat));
        }
        Redirect::to('/', array('message' => 'Vain adminit saavat selata muita käyttäjiä.'));
    }

    public static function handle_login() {
        $params = $_POST;

        $user = Kayttaja::authenticate($params['etunimi'], $params['sukunimi'], $params['password']);
        if (!$user) {
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'attributes' => $params));
        } else {
            $_SESSION['user'] = $user->id;
            if ($user->teacher) {
                $_SESSION['teacher'] = $user->teacher;
                if ($user->admin) {
                    $_SESSION['admin'] = $user->admin;
                }
            } else {
                $_SESSION['teacher'] = null;
                $_SESSION['admin'] = null;
            }
            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->username . '!'));
        }
    }

    public static function handle_logout() {
        $_SESSION['user'] = null;
        $_SESSION['teacher'] = null;
        $_SESSION['admin'] = null;
        Redirect::to('/user/login', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function handle_signup() {
        $params = $_POST;
        $user = new Kayttaja(array('username' => $params['etunimi'] . ' ' . $params['sukunimi'], 'password' => $params['salasana'], 'teacher' => isset($params['opettaja'])));
        $errors = self::getErrors($params);
        if (count($errors) == 0) {
            $new = $user->save();
            if ($new->teacher) {
                $opettaja = new Opettaja(array('etunimi' => $params['etunimi'], 'sukunimi' => $params['sukunimi'], 'opettajatunnus' => $new->id));
                $opettaja->save();
            } else {
                $oppilas = new Oppilas(array('etunimi' => $params['etunimi'], 'sukunimi' => $params['sukunimi'], 'opintopisteet' => 0, 'opiskelijanumero' => $new->id));
                $oppilas->save();
            }
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
        $errors = BaseModel::validate_string("salasana", $params['salasana'], 4, 50, $errors);
        return $errors;
    }

}
