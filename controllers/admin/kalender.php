<?php

class Kalender extends Controller {

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

        if (Session::get('user_access_level') == 5 || Session::get('user_is_admin') == 1) {
            // get all notices (of the logged in user)
            $this->view->event_list = $this->model->getAllEvents();
            $this->view->errors = $this->model->errors;
            $this->view->render('kalender/index', true);
        } else {
            header('location: ' . URL . 'admin/dashboard');
        }
    }

    public function create() {
        $this->model->createEvent(
                $_POST['event_date'], 
                $_POST['event_time'], 
                $_POST['event_name'], 
                $_POST['event_details'], 
                $_POST['all_day_event']);
        header('location: ' . URL . 'admin/kalender');
    }

    public function edit($reservation_id) {
        //TODO implement        
    }

    public function editSave($reservation_id) {
        //TODO implement
    }

    public function delete($reservation_id) {
        //TODO implement
    }

}
