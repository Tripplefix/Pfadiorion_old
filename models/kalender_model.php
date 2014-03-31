<?php

class Kalender_Model extends Model {
    
    public $errors = array();

    public function __construct() {
        parent::__construct();
    }
    
    public function getAllEvents(){
        $sth = $this->db->prepare("SELECT * FROM events");
        $sth->execute();
        $fetched_item = $sth->fetchAll();

        foreach ($fetched_item as $key => $value) {
            $hold = (array)$fetched_item[$key];
            $tmp_username = $this->db->prepare("SELECT user_name
                                           FROM users
                                           WHERE user_id = :user_id;");
            $tmp_username->execute(array(':user_id' => $hold['event_author']));
            
            $hold["user_name"] = $tmp_username->fetchAll()[0]->user_name;
            $fetched_item[$key] = (object)$hold;
        }
        return $fetched_item;
    }

    public function createEvent($event_date, $event_time, $event_name, $event_details, $all_day_event){
        $sth = $this->db->prepare("INSERT INTO events(
                                        event_date,
                                        event_name,
                                        event_details,
                                        all_day_event,
                                        event_author)
                                    VALUES (
                                        :event_date, 
                                        :event_name, 
                                        :event_details, 
                                        :all_day_event, 
                                        :event_author);");
        $date = explode(".", $event_date);
        $time = explode(":", $event_time);        
        $datetime = mktime($time[0], $time[1], 0, $date[1], $date[0], $date[2]);
        
        $sth->execute(array(
            ':event_date' => $datetime,
            ':event_name' => $event_name,
            ':event_details' => $event_details,
            ':all_day_event' => $all_day_event,
            ':event_author' => $_SESSION['user_id']));

        $count = $sth->rowCount();
        if ($count == 1) {
            return true;
        } else {
            return FEEDBACK_NOTE_CREATION_FAILED;
        }
    }
    
}
