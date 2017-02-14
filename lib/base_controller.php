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
    public static function is_teacher() {
        if (isset($_SESSION['teacher'])) {
            return $_SESSION['teacher'];
        }
        return null;
    }
    
    //EI TOIMI
    public static function is_student() {
        if (isset($_SESSION['teacher'])) {
            return null;
        }
        return true;
    }


    public static function is_admin() {
        if (isset($_SESSION['admin'])) {
            return $_SESSION['admin'];
        }
        return null;
    }
}
