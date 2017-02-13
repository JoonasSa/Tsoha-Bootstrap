<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['user'])) {
            return Kayttaja::find($_SESSION['user']);
        }
        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/user/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

    //EI TOIMI
    public static function is_student() {
        $kayttaja = self::get_user_logged_in();
        return !$kayttaja->teacher;
    }

    //EI TOIMI
    public static function is_teacher() {
        $kayttaja = self::get_user_logged_in();
        return $kayttaja->teacher;
    }

}
