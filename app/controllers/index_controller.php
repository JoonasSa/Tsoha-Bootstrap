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
        Kint::dump(BaseController::is_student());
        Kint::dump(BaseController::is_teacher());
        Kint::dump(BaseController::is_admin());
        
        
        //Kint::dump($c);
        View::make('hiekkalaatikko.html');
    }

}
