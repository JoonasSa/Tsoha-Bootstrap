<?php

class IndexController extends BaseController {

    public static function index() {
        View::make('home.html');
    }
    
    public static function edit() {
        View::make('edit.html');
    }

    public static function sandbox() {
        $a = $_SESSION['user'];
        Kint::dump($a);
        Kint::dump(BaseController::get_user_logged_in());
        Kint::dump(BaseController::get_is_student());
        Kint::dump(BaseController::get_is_teacher());
        Kint::dump(BaseController::get_is_admin());
        
        View::make('hiekkalaatikko.html');
    }

}
