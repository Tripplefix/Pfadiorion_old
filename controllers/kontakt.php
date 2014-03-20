<?php

class Kontakt extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->contacts = $this->model->getAllContacts();
        $this->view->render('kontakt/index');
    }

}
