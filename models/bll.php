<?php

class Business_Logic extends Model {
    
    public $errors = array();

    public function __construct() {
        parent::__construct();
    }
    
    public function getText($textId){
        $sth = $this->db->prepare("SELECT * FROM text WHERE text_id = :text_id AND language_id = :language_id");
        $sth->execute(array(':text_id' => $textId, 'language_id' => 'de'));
    }
}
