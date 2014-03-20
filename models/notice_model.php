<?php

/**
 * This is basically a simple CRUD demonstration.
 */
class Notice_Model extends Model {

    public $errors = array();

    public function __construct() {
        parent::__construct();
    }

    public function getAllNotices() {

        $sth = $this->db->prepare("SELECT * FROM notice WHERE datetime_abtreten > :now ORDER BY datetime_antreten DESC;");
        $sth->execute(array(':now' => strtotime(date('Y-m-d'))));
        $fetched_item = $sth->fetchAll();

        foreach ($fetched_item as $key => $value) {
            $hold = (array)$fetched_item[$key];
            $tmp_username = $this->db->prepare("SELECT user_name
                                           FROM users
                                           WHERE user_id = :user_id;");
            $tmp_username->execute(array(':user_id' => $hold['author']));
            
            $tmp_notice_group = $this->db->prepare("SELECT description
                                           FROM notice_group
                                           WHERE group_id = :group_id;");
            $tmp_notice_group->execute(array(':group_id' => $hold['notice_group_id']));
            
            $hold["user_name"] = $tmp_username->fetchAll()[0]->user_name;
            $hold["notice_group"] = $tmp_notice_group->fetchAll()[0]->description;
            $fetched_item[$key] = (object)$hold;
        }

        return $fetched_item;
    }
    
    public function getAllOutdatedNotices() {

        $sth = $this->db->prepare("SELECT * FROM notice WHERE datetime_abtreten <= :now ORDER BY datetime_antreten DESC;");
        $sth->execute(array(':now' => strtotime(date('Y-m-d'))));
        $fetched_item = $sth->fetchAll();

        foreach ($fetched_item as $key => $value) {
            $hold = (array)$fetched_item[$key];
            $tmp_username = $this->db->prepare("SELECT user_name
                                           FROM users
                                           WHERE user_id = :user_id;");
            $tmp_username->execute(array(':user_id' => $hold['author']));
            
            $tmp_notice_group = $this->db->prepare("SELECT description
                                           FROM notice_group
                                           WHERE group_id = :group_id;");
            $tmp_notice_group->execute(array(':group_id' => $hold['notice_group_id']));
            
            $hold["user_name"] = $tmp_username->fetchAll()[0]->user_name;
            $hold["notice_group"] = $tmp_notice_group->fetchAll()[0]->description;
            $fetched_item[$key] = (object)$hold;
        }

        return $fetched_item;
    }

    public function getNotice($notice_id) {

        $sth = $this->db->prepare("SELECT * FROM notice WHERE notice_id = :notice_id;");
        $sth->execute(array(':notice_id' => $notice_id));   

        return $sth->fetch();
    }

    public function create($date_antreten, $time_antreten, $date_abtreten, $time_abtreten, $place_antreten, $place_abtreten, $notice_content, $notice_group_id) {
        $sth = $this->db->prepare("INSERT INTO notice(
                                        datetime_antreten, 
                                        datetime_abtreten, 
                                        place_antreten, 
                                        place_abtreten, 
                                        notice_content, 
                                        notice_group_id, 
                                        author)
                                    VALUES (
                                        :datetime_antreten, 
                                        :datetime_abtreten, 
                                        :place_antreten, 
                                        :place_abtreten, 
                                        :notice_content, 
                                        :notice_group_id, 
                                        :user_id
                                    );");
        $date = explode(".", $date_antreten);
        $time = explode(":", $time_antreten);        
        $datetime_antreten = mktime($time[0], $time[1], 0, $date[1], $date[0], $date[2]);
        
        $date = explode(".", $date_abtreten);
        $time = explode(":", $time_abtreten);        
        $datetime_abtreten = mktime($time[0], $time[1], 0, $date[1], $date[0], $date[2]);
        
        $sth->execute(array(
            ':datetime_antreten' => $datetime_antreten,
            ':datetime_abtreten' => $datetime_abtreten,
            ':place_antreten' => $place_antreten,
            ':place_abtreten' => $place_abtreten,
            ':notice_content' => $notice_content,
            ':notice_group_id' => $notice_group_id,
            ':user_id' => $_SESSION['user_id']));

        $count = $sth->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_CREATION_FAILED;
            return false;
        }
    }

    public function editSave($notice_id, $date_antreten, $time_antreten, $date_abtreten, $time_abtreten, $place_antreten, $place_abtreten, $notice_content, $notice_group_id) {

        $sth = $this->db->prepare("UPDATE notice 
                                   SET 
                                        datetime_antreten = :datetime_antreten, 
                                        datetime_abtreten = :datetime_abtreten, 
                                        place_antreten = :place_antreten, 
                                        place_abtreten = :place_abtreten, 
                                        notice_content = :notice_content,
                                        notice_group_id = :notice_group_id
                                   WHERE notice_id = :notice_id;");
        $date = explode(".", $date_antreten);
        $time = explode(":", $time_antreten);        
        $datetime_antreten = mktime($time[0], $time[1], 0, $date[1], $date[0], $date[2]);
        
        $date = explode(".", $date_abtreten);
        $time = explode(":", $time_abtreten);        
        $datetime_abtreten = mktime($time[0], $time[1], 0, $date[1], $date[0], $date[2]);
        
        $sth->execute(array(
            ':datetime_antreten' => $datetime_antreten,
            ':datetime_abtreten' => $datetime_abtreten,
            ':place_antreten' => $place_antreten,
            ':place_abtreten' => $place_abtreten,
            ':notice_content' => $notice_content,
            ':notice_group_id' => $notice_group_id,
            ':notice_id' => $notice_id));

        $count = $sth->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_EDITING_FAILED;
            return false;
        }
    }

    public function delete($notice_id) {
        $sth = $this->db->prepare("DELETE FROM notice WHERE notice_id = :notice_id");
        $sth->execute(array(
            ':notice_id' => $notice_id));

        $count = $sth->rowCount();

        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_DELETION_FAILED;
            return false;
        }
    }

}
