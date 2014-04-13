<?php

class News extends Controller {

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

        // get all news (of the logged in user)
        $this->view->news_list_user = $this->model->getNewsOfUser();
        $this->view->news_list_all = $this->model->getAllNews();
        $this->view->errors = $this->model->errors;
        $this->view->render('news/index', true);
    }

    public function create() {

        $this->model->create($_POST['news_title'], $_POST['news_content']);
        header('location: ' . URL . 'admin/news');
    }

    public function edit($news_id) {

        $this->view->news = $this->model->getNews($news_id);
        $this->view->errors = $this->model->errors;
        $this->view->render('news/edit', true);
    }

    public function downloads() {
        $this->view->recent_downloads = $this->model->getRecentDownloads();
        $this->view->archived_downloads = $this->model->getArchivedDownloads();
        $this->view->render('news/downloads', true);
    }

    public function editSave($news_id) {

        // do editSave() in the news_model, passing news_id from URL and news_text from POST via params
        $this->model->editSave($news_id, $_POST['news_title'], $_POST['news_content']);
        header('location: ' . URL . 'admin/news');
    }

    public function delete($news_id) {

        $this->model->delete($news_id);
        header('location: ' . URL . 'admin/news');
    }

    //download
    public function create_download() {
        $errors = array();
        $server_url = 'public/download/';

        //upload file
        $allowedExts = array("doc", "docx", "xls", "xlsx", "pdf", "zip");
        $temp = explode(".", $_FILES["dl_file"]["name"]);
        $extension = end($temp);
        $max_file_size = 104857600;

        if ((($_FILES["dl_file"]["type"] == "application/msword") ||
                ($_FILES["dl_file"]["type"] == "application/vnd.ms-excel") ||
                ($_FILES["dl_file"]["type"] == "application/pdf") ||
                ($_FILES["dl_file"]["type"] == "application/zip")
                ) && ($_FILES["dl_file"]["size"] < $max_file_size) && in_array($extension, $allowedExts)) {
            if ($_FILES["dl_file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["dl_file"]["error"] . "<br>";
                $upload_successful = false;
            } else {
                $download_file_name = $_FILES["dl_file"]["name"];
                $dl_file_size = round(($_FILES["dl_file"]["size"] / 1024), 2) . " kB";
                echo "Upload: " . $_FILES["dl_file"]["name"] . "<br>";
                echo "Type: " . $_FILES["dl_file"]["type"] . "<br>";
                echo "Size: " . ($_FILES["dl_file"]["size"] / 1024) . " kB<br>";
                echo "Temp file: " . $_FILES["dl_file"]["tmp_name"] . "<br>";

                if (file_exists($server_url . $_FILES["dl_file"]["name"])) {
                    echo $_FILES["dl_file"]["name"] . " already exists. <br>";
                    $upload_successful = false;
                } else {
                    move_uploaded_file($_FILES["dl_file"]["tmp_name"], $server_url . $_FILES["dl_file"]["name"]);
                    echo "Stored in: " . $server_url . $_FILES["dl_file"]["name"] . "<br>";
                    $upload_successful = true;
                }
            }
        } else {
            echo "Invalid file<br>";
            $upload_successful = false;
        }

//        //create thumbnail
//        $im = new imagick('file.pdf[0]');
//        $im->setImageFormat('jpg');
//        header('Content-Type: image/jpeg');
//        echo $im;

        if ($upload_successful) {
            if ($this->model->insertDownload($_POST['dl_info'], $_POST['dl_title'], $download_file_name, $extension, 'no thumb, sorry :(', $dl_file_size)) {
                echo "Download erfolgreich eingef&uuml;gt";
                header('location: ' . URL . 'admin/news/downloads');
            } else {
                echo "Fehler beim Einf&uuml;gen in die Datenbank" . var_dump($this->model->errors);
            }
        } else {
            echo "Upload Fehlgeschlagen!";
        }
    }

    public function delete_download($dl_id) {
        if ($this->model->deleteDownload($dl_id)) {
            //unlink('public/download/' . $dl_id);
            echo 'done';
        } else {
            echo $this->model->errors[0];
        }
    }

    public function archive_download($dl_id) {
        if ($this->model->archiveDownload($dl_id)) {
            //unlink('public/download/' . $dl_id);
            echo 'done';
            header('location: ' . URL . 'admin/news/downloads');
        } else {
            echo $this->model->errors[0];
        }
    }

}
