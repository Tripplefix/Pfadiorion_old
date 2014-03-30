<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {

        //$this->view->users = $this->model->getAllUsersProfiles();
        if(Session::get('user_logged_in') == true){
            header('location: ' . URL . 'admin/notice');
        }else{
            $this->view->render('login/index', true);
        }
    }

    function details() {

        $this->view->render('index/index', true);
    }
}
