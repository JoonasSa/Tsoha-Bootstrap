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

    public static function get_is_teacher() {
        if (isset($_SESSION['teacher'])) {
            return Kayttaja::find($_SESSION['user']);
        }
        return null;
    }
    
    public static function get_is_student() {
        if (isset($_SESSION['teacher'])) {
            return null;
        } else if (!self::get_user_logged_in()) {
            return null;
        }
        return Kayttaja::find($_SESSION['user']);
    }

    public static function get_is_admin() {
        if (isset($_SESSION['admin'])) {
            return Kayttaja::find($_SESSION['user']);
        }
        return null;
    }
    
    public static function get_id() {
        $user = self::get_user_logged_in();
        if ($user) {
            return $user->id;
        }
        return null;
    }
}
