<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {

        //$this->view->users = $this->model->getAllUsersProfiles();
        $this->view->render('index/index', true);
    }

    function details() {

        $this->view->render('index/index', true);
    }
    
    //explemented
    /*function showuserprofile($user_id) {

        $this->view->user = $this->model->getUserProfile($user_id);
        $this->view->render('index/showuserprofile', true);
    }*/

}
