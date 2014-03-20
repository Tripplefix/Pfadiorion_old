<?php

class Pfadiheim extends Controller {
    
    function __construct() {
            parent::__construct();
    }

    function index() {

            $this->view->render('pfadiheim/index');
    }

    function details() {

            $this->view->render('pfadiheim/index');
    }
	
}