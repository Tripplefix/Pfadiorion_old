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
        if (Session::get('user_access_level') == 5 || Session::get('user_is_admin') == 1) {
            // get all notices (of the logged in user)
            $this->view->users = $this->model->getAllUser();
            $this->view->errors = $this->model->errors;
            $this->view->render('users/index', true);
        } else {
            header('location: ' . URL . 'admin/dashboard');
        }
    }

    public function getUserTypes() {
        $selected = $_POST['selected'];
        $select = '<select>';
        foreach ($this->model->getUserTypes() as $value) {
            $select .= ($selected == $value->description) 
                    ? '<option selected value="' . $value->access_level . '">' . $value->description . '</option>' 
                    : '<option value="' . $value->access_level . '">' . $value->description . '</option>';
        }
        $select .= '</select>';
        echo $select;
    }

    public function create() {
        if ($this->model->create(
                        $_POST['user_name'], $_POST['user_password'], $_POST['user_access_level'])) {
            header('location: ' . URL . 'admin/users');
            return true;
        } else {
            header('location: ' . URL . 'admin/users');
            return false;
        }
    }

    public function edit($user_id) {
        if($this->model->editUser($user_id, 
                $_POST['forename'], 
                $_POST['surname'], 
                $_POST['email'], 
                $_POST['birthdate'], 
                $_POST['street'], 
                $_POST['place'], 
                $_POST['phone'], 
                $_POST['type'], 
                $_POST['leadertraining'], 
                $_POST['leader_since'],
                $_POST['responsibility'])){
            echo "done";
        }else{
            echo $this->model->errors[0];
        }
    }

    public function editSave($user_id) {
        //TODO implement
    }

    public function delete($user_id) {
        if($this->model->delete($user_id)){
            echo 'done';
        }else{
            echo $this->model->errors[0];
        }
    }

}
