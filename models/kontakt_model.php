<?php

class Kontakt_Model extends Model {

    public $errors = array();

    public function __construct() {
        parent::__construct();
    }

    public function getContactsByType($id) {

        $sth = $this->db->prepare("SELECT   user_id, 
                                            user_color,
                                            user_name, 
                                            user_email, 
                                            user_contact_forename,
                                            user_contact_surname,
                                            user_contact_birthdate,
                                            user_contact_street,
                                            user_contact_place,
                                            user_contact_phone,
                                            user_leadertraining,
                                            user_leader_since,
                                            user_responsibility,
                                            user_has_avatar FROM users WHERE user_access_level = :user_access_level ORDER BY user_access_level DESC, user_responsibility");
        $sth->execute(array(':user_access_level' => $id));
        return $sth->fetchAll();
    }

}
