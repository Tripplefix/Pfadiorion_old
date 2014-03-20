<?php

class Notice extends Controller {

    public function __construct() {

        // a little note on that (seen on StackOverflow):
        // "As long as myChild has no constructor, the parent constructor will be called / inherited."
        // This means wenn a class thats extends another class has a __construct, it needs to construct
        // the parent in that constructor, like this:   
        parent::__construct();

        // VERY IMPORTANT: All controllers/areas that should only be useable by logged-in users
        // need this line! Otherwise not-logged in users could do actions
        // if all of your pages should only be useable by logged-in users: Put this line into
        // libs/Controller->__construct
        // TODO: test this!
        Auth::handleLogin();
    }

    public function index() {
        
        // get all notices (of the logged in user)
        $this->view->notice_list = $this->model->getAllNotices();
        $this->view->outdated_notice_list = $this->model->getAllOutdatedNotices();
        $this->view->errors = $this->model->errors;
        $this->view->render('notice/index', true);
    }

    public function create() {
        
        if($this->model->create(
                $_POST['date_antreten'], 
                $_POST['time_antreten'], 
                $_POST['date_abtreten'], 
                $_POST['time_abtreten'], 
                $_POST['place_antreten'], 
                $_POST['place_abtreten'], 
                $_POST['notice_content'], 
                $_POST['selected_notice_group'])){
            header('location: ' . URL . 'admin/notice');
            echo "test";
        }else{
            $this->view->errors = $this->model->errors;
            $this->view->render('notice/index', true);
        }
    }

    public function edit($notice_id) {
        
        $this->view->notice = $this->model->getNotice($notice_id);
        $this->view->errors = $this->model->errors;
        $this->view->render('notice/edit', true);
    }

    public function editSave($notice_id) {
         if($this->model->editSave(
                $notice_id, 
                $_POST['date_antreten'], 
                $_POST['time_antreten'], 
                $_POST['date_abtreten'], 
                $_POST['time_abtreten'], 
                $_POST['place_antreten'], 
                $_POST['place_abtreten'], 
                $_POST['notice_content'], 
                $_POST['selected_notice_group'])){
            header('location: ' . URL . 'admin/notice');       
         }else{
            $this->view->errors = $this->model->errors;
            header('location: ' . URL . 'admin/notice');   
         } 
    }

    public function delete($notice_id) {
        
        $this->model->delete($notice_id);
        header('location: ' . URL . 'admin/notice');
    }

}