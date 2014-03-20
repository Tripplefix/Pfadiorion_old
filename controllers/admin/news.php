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

    public function editSave($news_id) {
        
        // do editSave() in the news_model, passing news_id from URL and news_text from POST via params
        $this->model->editSave($news_id, $_POST['news_title'], $_POST['news_content']);
        header('location: ' . URL . 'admin/news');        
    }

    public function delete($news_id) {
        
        $this->model->delete($news_id);
        header('location: ' . URL . 'admin/news');
    }

}