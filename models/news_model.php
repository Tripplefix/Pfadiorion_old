<?php

/**
 * This is basically a simple CRUD demonstration.
 */
class News_Model extends Model {

    public $errors = array();

    public function __construct() {
        parent::__construct();
    }

    //region frontend
    public function showAllNews() {

        /* $sth = $this->db->prepare("SELECT user_id, news_id, news_title
          FROM news
          WHERE user_id = :user_id OR access_level < :access_level;"); */
        //vorläufig werden nur die Artikel angezeigt, die man selbst erstellt hat. Später soll man auch die Artikel seiner unterstellten Leiter bearbeiten und löschen können.
        $sth = $this->db->prepare("SELECT * FROM news ORDER BY news_date desc");
        $sth->execute();
        $fetched_item = $sth->fetchAll();

        foreach ($fetched_item as $key => $value ){
            $tmp = $this->db->prepare("SELECT user_name
                                           FROM users
                                           WHERE user_id = :user_id;");
            $hold = (array) $fetched_item[$key];
            $tmp->execute(array(':user_id' => $hold['user_id']));

            $hold["user_name"] = $tmp->fetchAll()[0]->user_name;
            $fetched_item[$key] = (object) $hold;
        }

        return $fetched_item;
    }

    public function showRecentNotices() {

        $sth = $this->db->prepare("SELECT * FROM notice
                                           WHERE datetime_abtreten > :now");
        $sth->execute(array(':now' => strtotime(date('Y-m-d'))));
        $fetched_item = $sth->fetchAll();

        foreach ($fetched_item as $key => $value) {
            $tmp = $this->db->prepare("SELECT description
                                           FROM notice_group
                                           WHERE group_id = :notice_group_id;");
            $hold = (array) $fetched_item[$key];
            $tmp->execute(array(':notice_group_id' => $hold['notice_group_id']));

            $hold["description"] = $tmp->fetchAll()[0]->description;
            $fetched_item[$key] = (object) $hold;
        }

        return $fetched_item;
    }
    
    public function showRecentEvents(){
        $sth = $this->db->prepare("SELECT * FROM events WHERE event_date > :now ORDER BY event_date DESC LIMIT 3");
        $sth->execute(array(':now' => strtotime(date('Y-m-d'))));
        return $sth->fetchAll();
    }
    
    public function showRecentReservations() {

        $sth = $this->db->prepare("SELECT * FROM pfadiheim_reservations
                                           WHERE date_start <= :now AND date_end >= :now");
        $sth->execute(array(':now' => strtotime(date('Y-m-d'))));
        return $sth->fetchAll();
    }
    
    public function showNotice($notice_id){

        $sth = $this->db->prepare("SELECT * FROM notice
                                           WHERE notice_id = :notice_id");
        $sth->execute(array(':notice_id' => $notice_id));
        return $sth->fetchAll();
    }
    
    public function showEvent($event_id){

        $sth = $this->db->prepare("SELECT * FROM events
                                           WHERE event_id = :event_id");
        $sth->execute(array(':event_id' => $event_id));
        return $sth->fetchAll();
    }
    
    public function getRecentDownloads(){
        $sth = $this->db->prepare("SELECT * FROM downloads WHERE download_is_recent = 1");
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function getArchivedDownloads(){
        $sth = $this->db->prepare("SELECT * FROM downloads WHERE download_is_recent <> 1");
        $sth->execute();
        return $sth->fetchAll();
    }
    //endregion

    //region backend
    public function getAllNews() {
        $sth = $this->db->prepare("SELECT user_id, news_id, news_title
                                           FROM news
                                           WHERE user_id <> :user_id;");
        $sth->execute(array(':user_id' => $_SESSION['user_id']));
        $fetched_item = $sth->fetchAll();

        foreach ($fetched_item as $key => $value) {
            $tmp = $this->db->prepare("SELECT user_name
                                           FROM users
                                           WHERE user_id = :user_id;");
            $hold = (array) $fetched_item[$key];
            $tmp->execute(array(':user_id' => $hold['user_id']));

            $hold["user_name"] = $tmp->fetchAll()[0]->user_name;
            $fetched_item[$key] = (object) $hold;
        }

        return $fetched_item;
    }
    
    public function getNewsOfUser() {
        $sth = $this->db->prepare("SELECT user_id, news_id, news_title
                                           FROM news
                                           WHERE user_id = :user_id;");
        $sth->execute(array(':user_id' => $_SESSION['user_id']));
        $fetched_item = $sth->fetchAll();

        foreach ($fetched_item as $key => $value) {
            $tmp = $this->db->prepare("SELECT user_name
                                           FROM users
                                           WHERE user_id = :user_id;");
            $hold = (array) $fetched_item[$key];
            $tmp->execute(array(':user_id' => $hold['user_id']));

            $hold["user_name"] = $tmp->fetchAll()[0]->user_name;
            $fetched_item[$key] = (object) $hold;
        }

        return $fetched_item;
    }

    public function getNews($news_id) {

        $sth = $this->db->prepare("SELECT * FROM news WHERE user_id = :user_id AND news_id = :news_id;");
        $sth->execute(array(
            ':user_id' => $_SESSION['user_id'],
            ':news_id' => $news_id));

        return $sth->fetch();
    }

    public function create($news_title, $news_content) {
        $sth = $this->db->prepare("INSERT INTO news
                                   (news_title, news_content, news_date, user_id)
                                   VALUES (:news_title, :news_content, :news_date, :user_id);");
        $sth->execute(array(
            ':news_title' => $news_title,
            ':news_content' => $news_content,
            ':news_date' => date('Y-m-d'),
            ':user_id' => $_SESSION['user_id']));

        $count = $sth->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_CREATION_FAILED;
            return false;
        }
    }

    public function editSave($news_id, $news_title, $news_content) {

        $sth = $this->db->prepare("UPDATE news 
                                   SET news_title = :news_title, news_content = :news_content
                                   WHERE news_id = :news_id AND user_id = :user_id;");
        $sth->execute(array(
            ':news_id' => $news_id,
            ':news_title' => $news_title,
            ':news_content' => $news_content,
            ':user_id' => $_SESSION['user_id']));

        $count = $sth->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_EDITING_FAILED;
            return false;
        }
    }

    public function delete($news_id) {
        $sth = $this->db->prepare("DELETE FROM news 
                                   WHERE news_id = :news_id AND user_id = :user_id;");
        $sth->execute(array(
            ':news_id' => $news_id,
            ':user_id' => $_SESSION['user_id']));

        $count = $sth->rowCount();

        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = FEEDBACK_NOTE_DELETION_FAILED;
            return false;
        }
    }

    public function getEvents($date){
        $sth = $this->db->prepare("SELECT * FROM events WHERE event_date >= :event_date_min AND event_date <= :event_date_max;");
        $sth->execute(array(':event_date_min' => $date, ':event_date_max' => $date + 86399));        
        return $sth->fetchAll();
    }
    
    //downloads
    public function insertDownload($info, $title, $file_name, $extension, $thumb, $file_size){
        $sth = $this->db->prepare("INSERT INTO downloads (download_info, 
                                                        download_title, 
                                                        download_file_name, 
                                                        download_file_type, 
                                                        download_thumb, 
                                                        download_size, 
                                                        download_is_recent) 
                                                    VALUES (:download_info, 
                                                        :download_title, 
                                                        :download_file_name, 
                                                        :download_file_type, 
                                                        :download_thumb, 
                                                        :download_size, 1);");
        $sth->execute(array(
            ':download_info' => $info,
            ':download_title' => $title,
            ':download_file_name' => $file_name,
            ':download_file_type' => $extension,
            ':download_thumb' => $thumb,
            ':download_size' => $file_size));

        $count = $sth->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = $sth->errorInfo();
            return false;
        }
    }
    
    public function deleteDownload($dl_id){
        $sth = $this->db->prepare("DELETE FROM downloads 
                                   WHERE download_id = :dl_id;");
        $sth->execute(array(':dl_id' => $dl_id));

        $count = $sth->rowCount();

        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = 'hätt nöd gfunzt!: ' . $dl_name;
            return false;
        }
    }
    
    public function archiveDownload($dl_id){
        $sth = $this->db->prepare("UPDATE downloads SET download_is_recent = 0
                                   WHERE download_id = :dl_id;");
        $sth->execute(array(':dl_id' => $dl_id));

        $count = $sth->rowCount();

        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = 'hätt nöd gfunzt!: ' . $dl_name;
            return false;
        }
    }
    
    //endregion
}
