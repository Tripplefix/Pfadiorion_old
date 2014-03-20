<?php

class Pfadiheim extends Controller {

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

        if (Session::get('user_access_level') == 5) {
            // get all notices (of the logged in user)
            $this->view->reservation_list = $this->model->getAllReservations();
            $this->view->errors = $this->model->errors;
            $this->view->render('pfadiheim/index', true);
        } else {
            header('location: ' . URL . 'admin/dashboard');
        }
    }

    public function create() {

        if ($this->model->create(
                        $_POST['date_start'], $_POST['time_start'], $_POST['date_end'], $_POST['time_end'], $_POST['tenant'], $_POST['details'])) {
            header('location: ' . URL . 'admin/pfadiheim');
            return true;
        } else {
            header('location: ' . URL . 'admin/pfadiheim');
            return false;
        }
    }

    public function edit($reservation_id) {
        //TODO implement        
    }

    public function editSave($reservation_id) {
        //TODO implement
    }

    public function delete($reservation_id) {
        
        $this->model->delete($notice_id);
        header('location: ' . URL . 'admin/pfadiheim');
    }

}
