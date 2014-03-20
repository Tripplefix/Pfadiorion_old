<?php

/**
 * This is basically a simple CRUD demonstration.
 */
class Pfadiheim_Model extends Model {

    public $errors = array();

    public function __construct() {
        parent::__construct();
    }

    public function getAllReservations() {

        $sth = $this->db->prepare("SELECT * FROM pfadiheim_reservations
                                           WHERE date_end > :date_end");
        $sth->execute(array(':date_end' => strtotime(date('Y-m-d'))));
        return $sth->fetchAll();
    }

    public function getReservation($reservation_id) {      
        //TODO implement        
    }

    public function create($date_start, $time_start, $date_end, $time_end, $tenant, $details) {      
        $sth = $this->db->prepare("INSERT INTO pfadiheim_reservations(
                                        date_start, 
                                        time_start, 
                                        date_end, 
                                        time_end, 
                                        tenant, 
                                        details, 
                                        creator_id)
                                    VALUES (
                                        :date_start, 
                                        :time_start, 
                                        :date_end, 
                                        :time_end, 
                                        :tenant, 
                                        :details, 
                                        :creator_id
                                    );");
        $sth->execute(array(
            ':date_start' => strtotime($date_start),
            ':time_start' => $time_start,
            ':date_end' => strtotime($date_end),
            ':time_end' => $time_end,
            ':tenant' => $tenant,
            ':details' => $details,
            ':creator_id' => $_SESSION['user_id']));

        $count = $sth->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_CREATION_FAILED;
            return false;
        }
    }

    public function editSave($reservation_id, $date_start, $time_start, $date_end, $time_end, $tenant, $details) {      
        //TODO implement        
    }

    public function deleteReservation($reservation_id) {      
        $sth = $this->db->prepare("DELETE FROM pfadiheim_reservations WHERE reservation_id = :reservation_id");
        $sth->execute(array(
            ':reservation_id' => $reservation_id));

        $count = $sth->rowCount();

        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_DELETION_FAILED;
            return false;
        }
    }

}
