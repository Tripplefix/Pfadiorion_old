<?php

class Login extends Controller {

    function __construct() {
        
        // a little note on that (seen on StackOverflow):
        // "As long as myChild has no constructor, the parent constructor will be called / inherited."
        // This means wenn a class thats extends another class has a __construct, it needs to construct
        // the parent in that constructor, like this:          
        parent::__construct();
    }

    function index() {
        
        $this->view->render('login/index', true);
    }
    
    function firstlogin(){
        
        if(Session::get('user_active') == 0){
            $this->view->render('login/firstlogin', true);
        }else{
            header('location: ' . URL . 'admin/dashboard');
        }
    }

    function login() {
        
        // run the login() method in the login-model, put the result in $login_successful (true or false)
        $login_successful = $this->model->login();

        // TODO: find a better solution than always doing this by hand
        // put the errors from the login model into the view (so we can display them in the view)
        $this->view->errors = $this->model->errors;

        // check login status
        if ($login_successful) {
            if(Session::get('user_active') == 0){
                header('location: ' . URL . 'admin/login/firstlogin');
            }else{
                header('location: ' . URL . 'admin/dashboard');
            }
        } else {
            
            // if NO, then show the login/index (login form) again
            $this->view->render('login/index', true);
        }
    }
    
    function logout()
    {
        $this->model->logout();
        header('location: ' . URL);
        //$this->view->render('login/index', true);
    }    

    function loginwithcookie()
    {
        // run the loginWithCookie() method in the login-model, put the result in $login_successful (true or false)
        $login_successful = $this->model->loginWithCookie();

        $this->view->errors = $this->model->errors; // useless in this case

        if ($login_successful) {

            $location = $this->model->getCookieUrl();
            header('location: ' . URL . 'admin/' . $location);

        } else {
            // delete the invalid cookie to prevent infinite login loops
            $this->model->deleteCookie();
            // render login/index view
            $this->view->render('login/index', true);
        }
    }

    function showprofile() {
        
        // Auth::handleLogin() makes sure that only logged in users can use this action/method and see that page
        Auth::handleLogin();        
        $this->view->render('login/showprofile', true);
        
    }
    
    function editusername() {
        
        // Auth::handleLogin() makes sure that only logged in users can use this action/method and see that page
        Auth::handleLogin();                
        $this->view->render('login/editusername', true);        
        
    }
    
    function editusername_action() {
        
        $this->model->editUserName();
        
        // TODO: find a better solution than always doing this by hand
        // put the errors from the login model into the view (so we can display them in the view)
        $this->view->errors = $this->model->errors;
        
        $this->view->render('login/editusername', true);        
        
    }    
    
    function edituseremail() {
        
        // Auth::handleLogin() makes sure that only logged in users can use this action/method and see that page
        Auth::handleLogin();                
        $this->view->render('login/edituseremail', true);
        
    }
    
    function edituseremail_action() {
        
        $this->model->editUserEmail();

        // TODO: find a better solution than always doing this by hand
        // put the errors from the login model into the view (so we can display them in the view)
        $this->view->errors = $this->model->errors;
        
        $this->view->render('login/edituseremail', true);        
        
    } 
    
    function uploadavatar() {
        
        // Auth::handleLogin() makes sure that only logged in users can use this action/method and see that page
        Auth::handleLogin();                
        
        $this->view->avatar_file_path = $this->model->getUserAvatarFilePath();
        $this->view->errors = $this->model->errors;
        
        $this->view->render('login/uploadavatar', true);        
    }
    
    function uploadavatar_action() {

        $this->model->createAvatar();

        // TODO: find a better solution than always doing this by hand
        // put the errors from the login model into the view (so we can display them in the view)
        $this->view->errors = $this->model->errors;
        
        $this->view->render('login/uploadavatar', true);

    }
    
    function changeaccounttype() {
        
        // Auth::handleLogin() makes sure that only logged in users can use this action/method and see that page
        Auth::handleLogin();
        $this->view->render('login/changeaccounttype', true);
        
    }
    
    function changeaccounttype_action() {
        
        $this->model->changeAccountType();
        $this->view->errors = $this->model->errors;
        
        $this->view->render('login/changeaccounttype', true);          
    }

    // register page
    function register() {    
        
        $this->view->render('login/register', true);        
    }
    
    // real registration action
    function register_action() {
        
        $registration_successful = $this->model->registerNewUser();

        // TODO: find a better solution than always doing this by hand
        // put the errors from the login model into the view (so we can display them in the view)
        $this->view->errors = $this->model->errors;
        
        if ($registration_successful == true) {
            $this->view->render('login/index', true);
        } else {
            $this->view->render('login/register', true);
        }        
        
    }
    
    function verify($user_id, $user_verification_code) {
        
        $this->model->verifyNewUser($user_id, $user_verification_code);

        // TODO: find a better solution than always doing this by hand
        // put the errors from the login model into the view (so we can display them in the view)
        $this->view->errors = $this->model->errors;
        
        $this->view->render('login/verify', true);        
    }
    
    function requestpasswordreset() {
        
        $this->view->render('login/requestpasswordreset', true);        
    }
    
    function requestpasswordreset_action() {
        
        //$this->model->requestPasswordReset();
        
        // set token (= a random hash string and a timestamp) into database, to see that THIS user really requested a password reset
        if ($this->model->setPasswordResetDatabaseToken() == true) {
        
            // send a mail to the user, containing a link with that token hash string
            $this->model->sendPasswordResetMail();
            
        }

        // TODO: find a better solution than always doing this by hand
        // put the errors from the login model into the view (so we can display them in the view)
        $this->view->errors = $this->model->errors;
        
        $this->view->render('login/requestpasswordreset', true);        
    }  
    
    function verifypasswordrequest($user_name, $verification_code) {
        
        if ($this->model->verifypasswordrequest($user_name, $verification_code)) {
            
            $this->view->user_name = $this->model->user_name;
            $this->view->user_password_reset_hash = $this->model->user_password_reset_hash;
            
            $this->view->errors = $this->model->errors;        
            $this->view->render('login/changepassword', true);
            
        } else {
            
            $this->view->errors = $this->model->errors;        
            $this->view->render('login/verificationfailed', true);
        }
        
    }
    
    function setnewpassword() {
        
        if ($this->model->setNewPassword()) {

            $this->view->errors = $this->model->errors;        
            $this->view->render('login/index', true);                    
            
        } else {

            $this->view->errors = $this->model->errors;        
            $this->view->render('login/changepassword', true);                                
            
        }
        
    }    
    
    function updatePassword($password) {
        
        if ($this->model->updatePassword($password)) {

            $this->view->errors = $this->model->errors;        
            $this->view->render('dashboard', true);                    
            
        } else {

            $this->view->errors = $this->model->errors;        
            $this->view->render('login/firstlogin', true);                                
            
        }
        
    }   
    
    /**
     * special helper method:
     * showCaptcha() returns an image, so we can use it in img tags in the views, like
     * <img src="......./login/showCaptcha" />
     */    
    function showCaptcha() {
        
            $captcha = new Captcha();
            // generate new string with captcha characters and write them into $_SESSION['captcha']
            $captcha->generateCaptcha();
            // render a img showing the characters (=the captcha)
            $captcha->showCaptcha();
    }   
    
    function updateuser(){
        if($this->model->updateUser($_POST['user_email'], $_POST['user_password'])== true){
            header('location: ' . URL . 'admin/dashboard');
        }else{
        $this->view->errors = $this->model->errors;
            $this->view->render('login/firstlogin', true);     
        }
    }

}