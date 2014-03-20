<?php

class Users extends Controller {

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
        $this->view->users = $this->model->getAllUser();
        $this->view->errors = $this->model->errors;
        $this->view->render('users/index', true);
    }

    public function create() {     
        if($this->model->create(
                $_POST['user_name'], 
                $_POST['user_password'], 
                $_POST['user_access_level'])){
            header('location: ' . URL . 'admin/users');
            return true;
        }else{
            header('location: ' . URL . 'admin/users');
            return false;
        }
    }

    public function edit($user_id) {        
        //TODO implement        
    }

    public function editSave($user_id) {
        //TODO implement
    }

    public function delete($user_id) {
        $this->model->delete($user_id);
        header('location: ' . URL . 'admin/users');
    }

}