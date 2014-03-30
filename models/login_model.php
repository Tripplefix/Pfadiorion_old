<?php

/**
 * class Login_Model
 * handles the user's login, logout, username editing, password changing...
 * 
 * @author Panique <panique@web.de>
 */
class Login_Model extends Model {

    public $errors = array();

    public function __construct() {

        parent::__construct();
    }

    public function login() {

        if (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // get user's data
            // (we check if the password fits the password_hash via password_verify() some lines below)
            $sth = $this->db->prepare("SELECT user_id, 
                                              user_name, 
                                              user_email, 
                                              user_password_hash, 
                                              user_active, 
                                              user_access_level,
                                              user_failed_logins, 
                                              user_last_failed_login,  
                                              user_is_admin
                                       FROM users
                                       WHERE user_name = :user_name ;");
            $sth->execute(array(':user_name' => $_POST['user_name']));

            $count = $sth->rowCount();
            if ($count == 1) {

                // fetch one row (we only have one result)
                $result = $sth->fetch();

                if (($result->user_failed_logins >= 2) && ($result->user_last_failed_login > (time() - 30))) {

                    $this->errors[] = FEEDBACK_PASSWORD_WRONG_3_TIMES;
                    return false;
                } else {

                    if (password_verify($_POST['user_password'], $result->user_password_hash)) {

                        if (!$result->user_active == 1) {
                            $this->errors[] = FEEDBACK_ACCOUNT_NOT_ACTIVATED_YET;
                            $this->errors["activated"] = false;
                        }

                        // login
                        Session::init();
                        Session::set('user_logged_in', true);
                        Session::set('user_id', $result->user_id);
                        Session::set('user_name', $result->user_name);
                        Session::set('user_email', $result->user_email);
                        Session::set('user_access_level', $result->user_access_level);
                        Session::set('user_active', $result->user_active);
                        Session::set('user_is_admin', $result->user_is_admin);

                        Session::set('user_avatar_file', $this->getUserAvatarFilePath());

                        // call the setGravatarImageUrl() method which writes gravatar urls into the session
                        $this->setGravatarImageUrl($result->user_email);

                        // reset the failed login counter for that user
                        $sth = $this->db->prepare("UPDATE users SET user_failed_logins = 0, user_last_failed_login = NULL WHERE user_id = :user_id AND user_failed_logins != 0");
                        $sth->execute(array(':user_id' => $result->user_id));

                        // if user has check the "remember me" checkbox, then write cookie
                        if (isset($_POST['user_rememberme'])) {

                            // generate 64 char random string
                            $random_token_string = hash('sha256', mt_rand());

                            $sth = $this->db->prepare("UPDATE users SET user_rememberme_token = :user_rememberme_token WHERE user_id = :user_id");
                            $sth->execute(array(':user_rememberme_token' => $random_token_string, ':user_id' => $result->user_id));

                            // generate cookie string that consists of userid, randomstring and combined hash of both
                            $cookie_string_first_part = $result->user_id . ':' . $random_token_string;
                            $cookie_string_hash = hash('sha256', $cookie_string_first_part);
                            $cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;

                            // set cookie
                            setcookie('rememberme', $cookie_string, time() + COOKIE_RUNTIME, "/", COOKIE_DOMAIN);
                        }

                        $this->errors["activated"] = true;
                        return true;
                    } else {

                        // increment the failed login counter for that user
                        $sth = $this->db->prepare("UPDATE users "
                                . "SET user_failed_logins = user_failed_logins+1, user_last_failed_login = :user_last_failed_login "
                                . "WHERE user_name = :user_name");
                        $sth->execute(array(':user_name' => $_POST['user_name'], ':user_last_failed_login' => time()));

                        $this->errors[] = FEEDBACK_PASSWORD_WRONG;
                        return false;
                    }
                }
            } else {
                $this->errors[] = FEEDBACK_USER_DOES_NOT_EXIST;
                return false;
            }
        } elseif (empty($_POST['user_name'])) {

            $this->errors[] = FEEDBACK_USERNAME_FIELD_EMPTY;
        } elseif (empty($_POST['user_password'])) {

            $this->errors[] = FEEDBACK_PASSWORD_FIELD_EMPTY;
        }
    }

    public function loginWithCookie() {

        $cookie = isset($_COOKIE['rememberme']) ? $_COOKIE['rememberme'] : '';

        if ($cookie) {

            list ($user_id, $token, $hash) = explode(':', $cookie);

            if ($hash !== hash('sha256', $user_id . ':' . $token)) {

                $this->errors[] = FEEDBACK_COOKIE_INVALID;
                return false;
            }

            // do not log in when token is empty
            if (empty($token)) {

                $this->errors[] = FEEDBACK_COOKIE_INVALID;
                return false;
            }

            // get real token from database (and all other data)
            $sth = $this->db->prepare("SELECT user_id,
                                              user_name,
                                              user_email,
                                              user_password_hash,
                                              user_active,
                                              user_access_level,
                                              user_has_avatar,
                                              user_failed_logins,
                                              user_last_failed_login
                                         FROM users
                                         WHERE user_id = :user_id
                                           AND user_rememberme_token = :user_rememberme_token
                                           AND user_rememberme_token IS NOT NULL");
            $sth->execute(array(':user_id' => $user_id, ':user_rememberme_token' => $token));

            $count = $sth->rowCount();
            if ($count == 1) {

                // fetch one row (we only have one result)
                $result = $sth->fetch();

                // TODO: this block is same/similar to the one from login(), maybe we should put this in a method
                // write data into session
                Session::init();
                Session::set('user_logged_in', true);
                Session::set('user_id', $result->user_id);
                Session::set('user_name', $result->user_name);
                Session::set('user_email', $result->user_email);
                Session::set('user_access_level', $result->user_access_level);

                Session::set('user_avatar_file', $this->getUserAvatarFilePath());

                // call the setGravatarImageUrl() method which writes gravatar urls into the session
                $this->setGravatarImageUrl($result->user_email);

                // NOTE: we don't set another rememberme-cookie here as the current cookie should always
                // be invalid after a certain amount of time, so the user has to login with username/password
                // again from time to time. This is good and safe ! ;)

                $this->errors[] = FEEDBACK_COOKIE_LOGIN_SUCCESSFUL;
                return true;
            } else {

                $this->errors[] = FEEDBACK_COOKIE_INVALID;
                return false;
            }
        } else {

            $this->errors[] = FEEDBACK_COOKIE_INVALID;
            return false;
        }
    }

    /**
     * @return string view/location
     */
    public function getCookieUrl() {

        if (!empty($_COOKIE['lastvisitedpage'])) {
            $url = $_COOKIE['lastvisitedpage'];
        } else {
            $url = '';
        }

        return $url;
    }

    /**
     * log out
     * delete cookie, delete session
     */
    public function logout() {

        // set the rememberme-cookie to ten years ago (3600sec * 365 days * 10).
        // that's obivously the best practice to kill a cookie via php
        // @see http://stackoverflow.com/a/686166/1114320
        setcookie('rememberme', false, time() - (3600 * 3650), '/');

        // delete the session
        Session::destroy();
    }

    /**
     * deletes the (invalid) remember-cookie to prevent infinitive login loops
     */
    public function deleteCookie() {

        // set the rememberme-cookie to ten years ago (3600sec * 365 days * 10).
        // that's obivously the best practice to kill a cookie via php
        // @see http://stackoverflow.com/a/686166/1114320
        setcookie('rememberme', false, time() - (3600 * 3650), '/');
    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn() {

        return Session::get('user_logged_in');
    }

    /**
     * edit the user's name, provided in the editing form
     */
    public function editUserName() {

        // email and password provided ?
        if (!empty($_POST['user_name']) && !empty($_POST["user_password"])) {

            if (!empty($_POST['user_name']) && $_POST['user_name'] == $_SESSION["user_name"]) {

                $this->errors[] = FEEDBACK_USERNAME_SAME_AS_OLD_ONE;
            }
            // username cannot be empty and must be azAZ09 and 2-64 characters
            // TODO: maybe this pattern should also be implemented in Registration.php (or other way round)
            elseif (!empty($_POST['user_name']) && preg_match("/^(?=.{2,64}$)[a-zA-Z][a-zA-Z0-9]*(?: [a-zA-Z0-9]+)*$/", $_POST['user_name'])) {

                // check if password is right
                $sth = $this->db->prepare("SELECT user_id,
                                                  user_password_hash
                                           FROM users
                                           WHERE user_id = :user_id");
                $sth->execute(array(':user_id' => $_SESSION['user_id']));

                $count = $sth->rowCount();
                if ($count == 1) {

                    // fetch one row (we only have one result)
                    $result = $sth->fetch();

                    if (password_verify($_POST['user_password'], $result->user_password_hash)) {

                        // escapin' this
                        $this->user_name = htmlentities($_POST['user_name'], ENT_QUOTES);
                        $this->user_name = substr($this->user_name, 0, 64); // TODO: is this really necessary ?
                        $this->user_id = $_SESSION['user_id']; // TODO: is this really necessary ?
                        // check if new username already exists
                        $sth = $this->db->prepare("SELECT * FROM users WHERE user_name = :user_name ;");
                        $sth->execute(array(':user_name' => $this->user_name));

                        $count = $sth->rowCount();

                        if ($count == 1) {

                            $this->errors[] = FEEDBACK_USERNAME_ALREADY_TAKEN;
                        } else {

                            $sth = $this->db->prepare("UPDATE users SET user_name = :user_name WHERE user_id = :user_id ;");
                            $sth->execute(array(':user_name' => $this->user_name, ':user_id' => $this->user_id));

                            $count = $sth->rowCount();

                            if ($count == 1) {

                                Session::set('user_name', $this->user_name);
                                $this->errors[] = FEEDBACK_USERNAME_CHANGE_SUCCESSFUL;
                            } else {

                                $this->errors[] = FEEDBACK_UNKNOWN_ERROR;
                            }
                        }
                    } else {

                        $this->errors[] = FEEDBACK_PASSWORD_WRONG;
                    }
                }
            } else {

                $this->errors[] = FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN;
            }
        } elseif (!empty($_POST['user_username'])) {

            $this->errors[] = FEEDBACK_PASSWORD_FIELD_EMPTY;
        } elseif (!empty($_POST['user_password'])) {

            $this->errors[] = FEEDBACK_USERNAME_FIELD_EMPTY;
        } else {

            $this->errors[] = FEEDBACK_USERNAME_AND_PASSWORD_FIELD_EMPTY;
        }
    }

    /**
     * edit the user's email, provided in the editing form
     */
    public function editUserEmail() {

        // email and password provided ?
        if (!empty($_POST['user_email']) && !empty($_POST["user_password"])) {

            // check if new email is same like the old one
            if (!empty($_POST['user_email']) && $_POST['user_email'] == $_SESSION["user_email"]) {

                $this->errors[] = FEEDBACK_EMAIL_SAME_AS_OLD_ONE;
            }
            // user mail must be in email format
            elseif (filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {

                // check if password is right
                $sth = $this->db->prepare("SELECT user_id,
                                                  user_password_hash
                                           FROM users
                                           WHERE user_id = :user_id");
                $sth->execute(array(':user_id' => $_SESSION['user_id']));

                $count = $sth->rowCount();
                if ($count == 1) {

                    // fetch one row (we only have one result)
                    $result = $sth->fetch();

                    if (password_verify($_POST['user_password'], $result->user_password_hash)) {

                        // escapin' this
                        $this->user_email = htmlentities($_POST['user_email'], ENT_QUOTES);
                        // prevent database flooding
                        $this->user_email = substr($this->user_email, 0, 64);

                        $sth = $this->db->prepare("UPDATE users SET user_email = :user_email WHERE user_id = :user_id ;");
                        $sth->execute(array(':user_email' => $this->user_email, ':user_id' => $_SESSION['user_id']));

                        $count = $sth->rowCount();

                        if ($count == 1) {

                            Session::set('user_email', $this->user_email);

                            // call the setGravatarImageUrl() method which writes gravatar urls into the session
                            $this->setGravatarImageUrl($this->user_email);

                            $this->errors[] = FEEDBACK_EMAIL_CHANGE_SUCCESSFUL;
                            return true;
                        } else {

                            $this->errors[] = FEEDBACK_UNKNOWN_ERROR;
                        }
                    } else {

                        $this->errors[] = FEEDBACK_PASSWORD_WRONG;
                    }
                }
            } else {

                $this->errors[] = FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN;
            }
        } elseif (!empty($_POST['user_email'])) {

            $this->errors[] = FEEDBACK_PASSWORD_FIELD_EMPTY;
        } elseif (!empty($_POST['user_password'])) {

            $this->errors[] = FEEDBACK_EMAIL_FIELD_EMPTY;
        } else {

            $this->errors[] = FEEDBACK_EMAIL_AND_PASSWORD_FIELDS_EMPTY;
        }
        return false;
    }

    /**
     * registerNewUser()
     * 
     * handles the entire registration process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     * @return boolean Gives back the success status of the registration
     */
    public function registerNewUser() {

        $captcha = new Captcha();

        if (!$captcha->checkCaptcha()) {

            $this->errors[] = FEEDBACK_CAPTCHA_WRONG;
        } elseif (empty($_POST['user_name'])) {

            $this->errors[] = FEEDBACK_USERNAME_FIELD_EMPTY;
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {

            $this->errors[] = FEEDBACK_PASSWORD_FIELD_EMPTY;
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {

            $this->errors[] = FEEDBACK_PASSWORD_REPEAT_WRONG;
        } elseif (strlen($_POST['user_password_new']) < 6) {

            $this->errors[] = FEEDBACK_PASSWORD_TOO_SHORT;
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {

            $this->errors[] = FEEDBACK_USERNAME_TOO_SHORT_OR_TOO_LONG;
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {

            $this->errors[] = FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN;
        } elseif (empty($_POST['user_email'])) {

            $this->errors[] = FEEDBACK_EMAIL_FIELD_EMPTY;
        } elseif (strlen($_POST['user_email']) > 64) {

            $this->errors[] = FEEDBACK_EMAIL_TOO_LONG;
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {

            $this->errors[] = FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN;
        } elseif (!empty($_POST['user_name']) && strlen($_POST['user_name']) <= 64 && strlen($_POST['user_name']) >= 2 && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name']) && !empty($_POST['user_email']) && strlen($_POST['user_email']) <= 64 && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['user_password_new']) && !empty($_POST['user_password_repeat']) && ($_POST['user_password_new'] === $_POST['user_password_repeat'])) {

            // escapin' this, additionally removing everything that could be (html/javascript-) code
            $this->user_name = htmlentities($_POST['user_name'], ENT_QUOTES);
            $this->user_email = htmlentities($_POST['user_email'], ENT_QUOTES);

            // no need to escape as this is only used in the hash function
            $this->user_password = $_POST['user_password_new'];

            // now it gets a little bit crazy: check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
            // if so: put the value into $this->hash_cost_factor, if not, make $this->hash_cost_factor = null
            $this->hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

            // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
            // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
            // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
            // want the parameter: as an array with, currently only used with 'cost' => XX.
            $this->user_password_hash = password_hash($this->user_password, PASSWORD_DEFAULT, array('cost' => $this->hash_cost_factor));

            // check if user already exists                
            $sth = $this->db->prepare("SELECT * FROM users WHERE user_name = :user_name ;");
            $sth->execute(array(':user_name' => $this->user_name));

            $count = $sth->rowCount();

            if ($count == 1) {

                $this->errors[] = FEEDBACK_USERNAME_ALREADY_TAKEN;
            } else {

                // generate random hash for email verification (40 char string)
                $this->user_activation_hash = sha1(uniqid(mt_rand(), true));

                // write new users data into database
                //$query_new_user_insert = $this->db_connection->query("INSERT INTO users (user_name, user_password_hash, user_email, user_activation_hash) VALUES('".$this->user_name."', '".$this->user_password_hash."', '".$this->user_email."', '".$this->user_activation_hash."');");

                $sth = $this->db->prepare("INSERT INTO users (user_name, user_password_hash, user_email, user_activation_hash) VALUES(:user_name, :user_password_hash, :user_email, :user_activation_hash) ;");
                $sth->execute(array(':user_name' => $this->user_name, ':user_password_hash' => $this->user_password_hash, ':user_email' => $this->user_email, ':user_activation_hash' => $this->user_activation_hash));

                $count = $sth->rowCount();

                if ($count == 1) {

                    $this->user_id = $this->db->lastInsertId();

                    // send a verification email
                    if ($this->sendVerificationEmail()) {

                        // when mail has been send successfully
                        $this->messages[] = FEEDBACK_ACCOUNT_SUCCESSFULLY_CREATED;
                        $this->registration_successful = true;
                        return true;
                    } else {

                        // delete this users account immediately, as we could not send a verification email
                        // the row (which will be deleted) is identified by PDO's lastinserid method (= the last inserted row)
                        // @see http://www.php.net/manual/en/pdo.lastinsertid.php

                        $sth = $this->db->prepare("DELETE FROM users WHERE user_id = :last_inserted_id ;");
                        $sth->execute(array(':last_inserted_id' => $this->db->lastInsertId()));

                        $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_FAILED;
                    }
                } else {

                    $this->errors[] = FEEDBACK_ACCOUNT_CREATION_FAILED;
                }
            }
        } else {

            $this->errors[] = FEEDBACK_UNKNOWN_ERROR;
        }

        // standard return. returns only true of really successful (see above)
        return false;
    }

    /**
     * sendVerificationEmail()
     * sends an email to the provided email address
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
     */
    private function sendVerificationEmail() {

        $mail = new PHPMailer;

        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_SMTP) {

            // Set mailer to use SMTP
            $mail->IsSMTP();
            //useful for debugging, shows full SMTP errors
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            // Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
            // Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {

            $mail->IsMail();
        }

        $mail->From = EMAIL_VERIFICATION_FROM_EMAIL;
        $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
        $mail->AddAddress($this->user_email);
        $mail->Subject = EMAIL_VERIFICATION_SUBJECT;
        $mail->Body = EMAIL_VERIFICATION_CONTENT . EMAIL_VERIFICATION_URL . '/' . urlencode($this->user_id) . '/' . urlencode($this->user_activation_hash);

        if (!$mail->Send()) {

            $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_ERROR . $mail->ErrorInfo;
            return false;
        } else {

            $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_SUCCESSFUL;
            return true;
        }
    }

    /**
     * verifyNewUser()
     * checks the email/verification code combination and set the user's activation status to true (=1) in the database
     */
    public function verifyNewUser($user_id, $user_verification_code) {

        $sth = $this->db->prepare("UPDATE users SET user_active = 1, user_activation_hash = NULL WHERE user_id = :user_id AND user_activation_hash = :user_activation_hash ;");
        $sth->execute(array(':user_id' => $user_id, ':user_activation_hash' => $user_verification_code));

        if ($sth->rowCount() > 0) {

            $this->errors[] = FEEDBACK_ACCOUNT_ACTIVATION_SUCCESSFUL;
        } else {

            $this->errors[] = FEEDBACK_ACCOUNT_ACTIVATION_FAILED;
        }
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     * Gravatar is the #1 (free) provider for email address based global avatar hosting.
     * The URL (or image) returns always a .jpg file !
     * For deeper info on the different parameter possibilities:
     * @see http://gravatar.com/site/implement/images/
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 50px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public function setGravatarImageUrl($email, $s = 44, $d = 'mm', $r = 'pg', $atts = array()) {

        // TODO: why is this set when it's more a get ?

        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";

        // the image url (on gravatarr servers), will return in something like
        // http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=80&d=mm&r=g
        // note: the url does NOT have something like .jpg
        Session::set('user_gravatar_image_url', $url);

        // build img tag around
        $url_with_tag = '<img src="' . $url . '"';
        foreach ($atts as $key => $val) {
            $url_with_tag .= ' ' . $key . '="' . $val . '"';
        }
        $url_with_tag .= ' />';

        // the image url like above but with an additional <img src .. /> around
        Session::set('user_gravatar_image_tag', $url_with_tag);
    }

    /**
     * Gets the user's avatar file path
     * @return string
     */
    public function getUserAvatarFilePath() {

        $sth = $this->db->prepare("SELECT user_has_avatar FROM users WHERE user_id = :user_id");
        $sth->execute(array(':user_id' => $_SESSION['user_id']));

        if ($sth->fetch()->user_has_avatar) {

            return URL . AVATAR_PATH . $_SESSION['user_id'] . '.jpg';
        }
    }

    public function createAvatar() {

        if (is_dir(AVATAR_PATH) && is_writable(AVATAR_PATH)) {

            if (!empty($_FILES['avatar_file']['tmp_name'])) {

                // get the image width, height and mime type
                // btw: why does PHP call this getimagesize when it gets much more than just the size ?
                $image_proportions = getimagesize($_FILES['avatar_file']['tmp_name']);

                // dont handle files > 5MB
                if ($_FILES['avatar_file']['size'] <= 5000000) {

                    if ($image_proportions[0] >= 100 && $image_proportions[1] >= 100) {

                        if ($image_proportions['mime'] == 'image/jpeg' || $image_proportions['mime'] == 'image/png') {

                            $target_file_path = AVATAR_PATH . $_SESSION['user_id'] . ".jpg";

                            // creates a 44x44px avatar jpg file in the avatar folder
                            // see the function defintion (also in this class) for more info on how to use
                            $this->resize_image($_FILES['avatar_file']['tmp_name'], $target_file_path, 400, 400, 85, true);

                            $sth = $this->db->prepare("UPDATE users SET user_has_avatar = TRUE WHERE user_id = :user_id");
                            $sth->execute(array(':user_id' => $_SESSION['user_id']));

                            Session::set('user_avatar_file', $this->getUserAvatarFilePath());

                            $this->errors[] = FEEDBACK_AVATAR_UPLOAD_SUCCESSFUL;
                        } else {

                            $this->errors[] = FEEDBACK_AVATAR_UPLOAD_WRONG_TYPE;
                        }
                    } else {

                        $this->errors[] = FEEDBACK_AVATAR_UPLOAD_TOO_SMALL;
                    }
                } else {

                    $this->errors[] = FEEDBACK_AVATAR_UPLOAD_TOO_BIG;
                }
            }
        } else {

            $this->errors[] = FEEDBACK_AVATAR_FOLDER_NOT_WRITEABLE;
        }
    }

    /**
     * Resize Image
     *
     * Takes the source image and resizes it to the specified width & height or proportionally if crop is off.
     * @access public
     * @author Jay Zawrotny <jayzawrotny@gmail.com>
     * @license Do whatever you want with it.
     * @param string $source_image The location to the original raw image.
     * @param string $destination_filename The location to save the new image.
     * @param int $width The desired width of the new image
     * @param int $height The desired height of the new image.
     * @param int $quality The quality of the JPG to produce 1 - 100
     * @param bool $crop Whether to crop the image or not. It always crops from the center.
     */
    function resize_image($source_image, $destination_filename, $width = 400, $height = 400, $quality = 85, $crop = true) {

        if (!$image_data = getimagesize($source_image)) {
            return false;
        }

        switch ($image_data['mime']) {
            case 'image/gif':
                $get_func = 'imagecreatefromgif';
                $suffix = ".gif";
                break;
            case 'image/jpeg';
                $get_func = 'imagecreatefromjpeg';
                $suffix = ".jpg";
                break;
            case 'image/png':
                $get_func = 'imagecreatefrompng';
                $suffix = ".png";
                break;
        }

        $img_original = call_user_func($get_func, $source_image);
        $old_width = $image_data[0];
        $old_height = $image_data[1];
        $new_width = $width;
        $new_height = $height;
        $src_x = 0;
        $src_y = 0;
        $current_ratio = round($old_width / $old_height, 2);
        $desired_ratio_after = round($width / $height, 2);
        $desired_ratio_before = round($height / $width, 2);

        if ($old_width < $width || $old_height < $height) {

            // The desired image size is bigger than the original image. 
            // Best not to do anything at all really.
            return false;
        }

        // If the crop option is left on, it will take an image and best fit it
        // so it will always come out the exact specified size.
        if ($crop) {

            // create empty image of the specified size
            $new_image = imagecreatetruecolor($width, $height);

            // Landscape Image
            if ($current_ratio > $desired_ratio_after) {
                $new_width = $old_width * $height / $old_height;
            }

            // Nearly square ratio image.
            if ($current_ratio > $desired_ratio_before && $current_ratio < $desired_ratio_after) {

                if ($old_width > $old_height) {
                    $new_height = max($width, $height);
                    $new_width = $old_width * $new_height / $old_height;
                } else {
                    $new_height = $old_height * $width / $old_width;
                }
            }

            // Portrait sized image
            if ($current_ratio < $desired_ratio_before) {
                $new_height = $old_height * $width / $old_width;
            }

            // Find out the ratio of the original photo to it's new, thumbnail-based size
            // for both the width and the height. It's used to find out where to crop.
            $width_ratio = $old_width / $new_width;
            $height_ratio = $old_height / $new_height;

            // Calculate where to crop based on the center of the image
            $src_x = floor(( ( $new_width - $width ) / 2 ) * $width_ratio);
            $src_y = round(( ( $new_height - $height ) / 2 ) * $height_ratio);
        }
        // Don't crop the image, just resize it proportionally
        else {

            if ($old_width > $old_height) {
                $ratio = max($old_width, $old_height) / max($width, $height);
            } else {
                $ratio = max($old_width, $old_height) / min($width, $height);
            }

            $new_width = $old_width / $ratio;
            $new_height = $old_height / $ratio;

            $new_image = imagecreatetruecolor($new_width, $new_height);
        }

        // Where all the real magic happens
        imagecopyresampled($new_image, $img_original, 0, 0, $src_x, $src_y, $new_width, $new_height, $old_width, $old_height);

        // Save it as a JPG File with our $destination_filename param.
        imagejpeg($new_image, $destination_filename, $quality);

        // Destroy the evidence!
        imagedestroy($new_image);
        imagedestroy($img_original);

        // Return true because it worked and we're happy. Let the dancing commence!
        return true;
    }

    /**
     * 
     */
    public function setPasswordResetDatabaseToken() {

        if (empty($_POST['user_name'])) {

            $this->errors[] = "Empty username";
        } else {

            // generate timestamp (to see when exactly the user (or an attacker) requested the password reset mail)
            // btw this is an integer ;)
            $temporary_timestamp = time();

            // generate random hash for email password reset verification (40 char string)
            $this->user_password_reset_hash = sha1(uniqid(mt_rand(), true));

            // TODO: this is not totally clean, as this is just the form provided username
            $this->user_name = htmlentities($_POST['user_name'], ENT_QUOTES);

            $sth = $this->db->prepare("SELECT user_id, user_email FROM users WHERE user_name = :user_name ;");
            $sth->execute(array(':user_name' => $this->user_name));

            $count = $sth->rowCount();

            if ($count == 1) {

                // get result row (as an object)
                $result_user_row = $result = $sth->fetch();

                // database query: 
                $sth2 = $this->db->prepare("UPDATE users 
                                           SET user_password_reset_hash = :user_password_reset_hash, 
                                               user_password_reset_timestamp = :user_password_reset_timestamp 
                                           WHERE user_name = :user_name ;");
                $sth2->execute(array(':user_password_reset_hash' => $this->user_password_reset_hash,
                    ':user_password_reset_timestamp' => $temporary_timestamp,
                    ':user_name' => $this->user_name));

                // check if exactly one row was successfully changed:
                $count = $sth2->rowCount();

                if ($count == 1) {

                    // define email
                    $this->user_email = $result_user_row->user_email;

                    return true;
                } else {

                    $this->errors[] = FEEDBACK_PASSWORD_RESET_TOKEN_FAIL; // maybe say something not that technical.
                }
            } else {

                $this->errors[] = FEEDBACK_USER_DOES_NOT_EXIST;
            }
        }

        // return false (this method only returns true when the database entry has been set successfully)
        return false;
    }

    public function sendPasswordResetMail() {

        $mail = new PHPMailer;

        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_SMTP) {

            // Set mailer to use SMTP
            $mail->IsSMTP();
            //useful for debugging, shows full SMTP errors
            //$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            // Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
            // Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {

            $mail->IsMail();
        }

        $mail->From = EMAIL_PASSWORDRESET_FROM_EMAIL;
        $mail->FromName = EMAIL_PASSWORDRESET_FROM_NAME;
        $mail->AddAddress($this->user_email);
        $mail->Subject = EMAIL_PASSWORDRESET_SUBJECT;

        $link = EMAIL_PASSWORDRESET_URL . '/' . urlencode($this->user_name) . '/' . urlencode($this->user_password_reset_hash);
        $mail->Body = EMAIL_PASSWORDRESET_CONTENT . ' <a href="' . $link . '">' . $link . '</a>';

        if (!$mail->Send()) {

            $this->errors[] = FEEDBACK_PASSWORD_RESET_MAIL_SENDING_ERROR . $mail->ErrorInfo;
            return false;
        } else {

            $this->errors[] = FEEDBACK_PASSWORD_RESET_MAIL_SENDING_SUCCESSFUL;
            return true;
        }
    }

    /**
     * 
     */
    public function verifypasswordrequest($user_name, $verification_code) {

        // TODO: this is not totally clean, as this is just the form provided username
        $this->user_name = htmlentities($user_name, ENT_QUOTES);
        $this->user_password_reset_hash = htmlentities($verification_code, ENT_QUOTES);

        $sth = $this->db->prepare("SELECT user_id, user_password_reset_timestamp 
                                   FROM users 
                                   WHERE user_name = :user_name 
                                      && user_password_reset_hash = :user_password_reset_hash;");
        $sth->execute(array(':user_password_reset_hash' => $verification_code,
            ':user_name' => $user_name));

        // if this user exists
        if ($sth->rowCount() == 1) {

            // get result row (as an object)
            $result_user_row = $sth->fetch();
            // 3600 seconds are 1 hour
            $timestamp_one_hour_ago = time() - 3600;

            if ($result_user_row->user_password_reset_timestamp > $timestamp_one_hour_ago) {

                // verification was sucessful
                return true;
            } else {

                $this->errors[] = FEEDBACK_PASSWORD_RESET_LINK_EXPIRED;
                return false;
            }
        } else {

            $this->errors[] = FEEDBACK_PASSWORD_RESET_COMBINATION_DOES_NOT_EXIST;
            return false;
        }
    }

    public function setNewPassword() {

        // TODO: timestamp!

        if (!empty($_POST['user_name']) && !empty($_POST['user_password_reset_hash']) && !empty($_POST['user_password_new']) && !empty($_POST['user_password_repeat'])) {

            if ($_POST['user_password_new'] === $_POST['user_password_repeat']) {

                if (strlen($_POST['user_password_new']) >= 6) {

                    // escapin' this, additionally removing everything that could be (html/javascript-) code
                    $this->user_name = htmlentities($_POST['user_name'], ENT_QUOTES);
                    $this->user_password_reset_hash = htmlentities($_POST['user_password_reset_hash'], ENT_QUOTES);

                    // no need to escape as this is only used in the hash function
                    $this->user_password = $_POST['user_password_new'];

                    // now it gets a little bit crazy: check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                    // if so: put the value into $this->hash_cost_factor, if not, make $this->hash_cost_factor = null
                    $this->hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

                    // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                    // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                    // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                    // want the parameter: as an array with, currently only used with 'cost' => XX.
                    $this->user_password_hash = password_hash($this->user_password, PASSWORD_DEFAULT, array('cost' => $this->hash_cost_factor));

                    // write users new hash into database
                    $sth = $this->db->prepare("UPDATE users
                                            SET user_password_hash = :user_password_hash, 
                                                user_password_reset_hash = NULL, 
                                                user_password_reset_timestamp = NULL
                                            WHERE user_name = :user_name  
                                               && user_password_reset_hash = :user_password_reset_hash ;");

                    $sth->execute(array(':user_password_hash' => $this->user_password_hash,
                        ':user_name' => $this->user_name,
                        ':user_password_reset_hash' => $this->user_password_reset_hash));

                    // check if exactly one row was successfully changed:
                    if ($sth->rowCount() == 1) {

                        $this->errors[] = FEEDBACK_PASSWORD_CHANGE_SUCCESSFUL;
                        return true;
                    } else {

                        $this->errors[] = FEEDBACK_PASSWORD_CHANGE_FAILED;
                    }
                } else {

                    $this->errors[] = FEEDBACK_PASSWORD_TOO_SHORT;
                }
            } else {

                $this->errors[] = FEEDBACK_PASSWORD_REPEAT_WRONG;
            }
        }

        // default
        return false;
    }

    /**
     * Upgrades/downgrades the user's account
     * Currently it's just the field user_access_level in the database that
     * can be 1 or 2 (maybe "basic" or "premium"). In this basic method we
     * simply increase or decrease this value to emulate an account upgrade/downgrade.
     * 
     * Put some more complex stuff in here, maybe a pay-process or whatever you like.
     * 
     */
    public function changeAccountType() {

        if (!empty($_POST["user_account_upgrade"])) {

            // do whatever you want to upgrade the account here (pay-process etc)
            // ....

            $sth = $this->db->prepare("UPDATE users SET user_access_level = 2 WHERE user_id = :user_id");
            $sth->execute(array(':user_id' => $_SESSION["user_id"]));

            if ($sth->rowCount() == 1) {

                // set account type in session to 2
                Session::set('user_access_level', 2);

                $this->errors[] = FEEDBACK_ACCOUNT_UPGRADE_SUCCESSFUL;
            } else {

                $this->errors[] = FEEDBACK_ACCOUNT_UPGRADE_FAILED;
            }
        } elseif (!empty($_POST["user_account_downgrade"])) {

            // do whatever you want to downgrade the account here (pay-process etc)
            // ....            

            $sth = $this->db->prepare("UPDATE users SET user_access_level = 1 WHERE user_id = :user_id");
            $sth->execute(array(':user_id' => $_SESSION["user_id"]));

            if ($sth->rowCount() == 1) {

                // set account type in session to 1
                Session::set('user_access_level', 1);

                $this->errors[] = FEEDBACK_ACCOUNT_DOWNGRADE_SUCCESSFUL;
            } else {

                $this->errors[] = FEEDBACK_ACCOUNT_DOWNGRADE_FAILED;
            }
        }
    }

    public function updateUser($user_email, $password) {
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL) && !empty($password)) {

            // now it gets a little bit crazy: check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
            // if so: put the value into $this->hash_cost_factor, if not, make $this->hash_cost_factor = null
            $this->hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

            // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
            // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
            // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
            // want the parameter: as an array with, currently only used with 'cost' => XX.
            $this->user_password_hash = password_hash($password, PASSWORD_DEFAULT, array('cost' => $this->hash_cost_factor));

            // escapin' this
            $this->user_email = htmlentities($user_email, ENT_QUOTES);
            // prevent database flooding
            $this->user_email = substr($this->user_email, 0, 64);

            $sth = $this->db->prepare("UPDATE users SET "
                    . "user_active = 1, "
                    . "user_password_hash = :user_password_hash, "
                    . "user_email = :user_email WHERE user_id = :user_id ;");
            $sth->execute(array(
                ':user_password_hash' => $this->user_password_hash,
                ':user_email' => $this->user_email,
                ':user_id' => $_SESSION['user_id']));

            $count = $sth->rowCount();

            if ($count == 1) {

                Session::set('user_email', $this->user_email);

                // call the setGravatarImageUrl() method which writes gravatar urls into the session
                $this->setGravatarImageUrl($this->user_email);

                $this->errors[] = FEEDBACK_EMAIL_CHANGE_SUCCESSFUL;
                return true;
            } else {

                $this->errors[] = FEEDBACK_UNKNOWN_ERROR;
            }
        } else {

            $this->errors[] = FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN;
        }
        return false;
    }

    public function getProfileInfos() {
        $sth = $this->db->prepare("SELECT user_contact_forename, 
            user_contact_surname, 
            user_contact_birthdate,
            user_contact_street,
            user_contact_place,
            user_contact_phone, 
            user_email, 
            user_leadertraining,
            user_leader_since,
            user_responsibility FROM users WHERE user_id = :user_id");
        $sth->execute(array(':user_id' => $_SESSION['user_id']));
        return $sth->fetch();
    }

    public function saveProfileChanges($email, $forename, $surname, $birthdate, $street, $place, $phone) {
        $birthdate = $birthdate == "" ? null : $birthdate;
        $street = $street == "" ? null : $street;
        $place = $place == "" ? null : $place;
        $phone = $phone == "" ? null : $phone;

        $sth = $this->db->prepare("UPDATE users SET 
                    user_email = :email, 
                    user_contact_forename = :forename, 
                    user_contact_forename = :forename, 
                    user_contact_surname = :surname, 
                    user_contact_birthdate = :birthdate, 
                    user_contact_street = :street, 
                    user_contact_place = :place, 
                    user_contact_phone = :phone WHERE user_id = :user_id ;");
        $sth->execute(array(
            ':email' => $email,
            ':forename' => $forename,
            ':surname' => $surname,
            ':birthdate' => $birthdate,
            ':street' => $street,
            ':place' => $place,
            ':phone' => $phone,
            ':user_id' => $_SESSION['user_id']));

        $count = $sth->rowCount();
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }

}
