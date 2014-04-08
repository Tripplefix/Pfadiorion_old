<?php

/**
 * This is basically a simple CRUD demonstration.
 */
class Users_Model extends Model {

    public $errors = array();

    public function __construct() {
        parent::__construct();
    }

    public function getAllUser() {
        $sth = $this->db->prepare("SELECT * FROM users ORDER BY user_name");
        $sth->execute(array(':user_id' => $_SESSION['user_id']));
        //return $sth->fetchAll();


        $fetched_item = $sth->fetchAll();

        foreach ($fetched_item as $key => $value) {
            $hold = (array) $fetched_item[$key];
            $tmp_user_type = $this->db->prepare("SELECT description
                                           FROM user_groups
                                           WHERE access_level = :access_level;");
            $tmp_user_type->execute(array(':access_level' => $hold['user_access_level']));

            $hold["user_type"] = $tmp_user_type->fetchAll()[0]->description;
            $fetched_item[$key] = (object) $hold;
        }

        return $fetched_item;
    }

    public function getUser($user_id) {
        $sth = $this->db->prepare("SELECT * FROM users WHERE user_id == :user_id");
        $sth->execute(array(':user_id' => $user_id));

        $fetched_item = $sth->fetchAll();

        foreach ($fetched_item as $key => $value) {
            $hold = (array) $fetched_item[$key];
            $tmp_user_type = $this->db->prepare("SELECT description
                                           FROM user_groups
                                           WHERE access_level = :access_level;");
            $tmp_user_type->execute(array(':access_level' => $hold['user_access_level']));

            $hold["user_type"] = $tmp_user_type->fetchAll()[0]->description;
            $fetched_item[$key] = (object) $hold;
        }

        return $fetched_item;
    }

    public function getUserTypes() {
        $sth = $this->db->prepare("SELECT * FROM user_groups");
        $sth->execute();

        return $sth->fetchAll();
    }

    public function create($user_name, $user_password, $user_access_level) {

        if (empty($user_name)) {

            $this->errors[] = FEEDBACK_USERNAME_FIELD_EMPTY;
        } elseif (strlen($user_name) > 64 || strlen($user_name) < 2) {

            $this->errors[] = FEEDBACK_USERNAME_TOO_SHORT_OR_TOO_LONG;
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $user_name)) {

            $this->errors[] = FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN;
        } elseif (!empty($user_name) && strlen($user_name) <= 64 && strlen($user_name) >= 2 && preg_match('/^[a-z\d]{2,64}$/i', $user_name)) {

            // escapin' this, additionally removing everything that could be (html/javascript-) code
            $this->user_name = htmlentities($user_name, ENT_QUOTES);
            $this->user_access_level = $user_access_level;

            $this->user_password = $user_password;

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

                $sth = $this->db->prepare("INSERT INTO users "
                        . "(user_name, user_password_hash, user_activation_hash, user_access_level) "
                        . "VALUES(:user_name, :user_password_hash, :user_activation_hash, :user_access_level);");
                $sth->execute(array(
                    ':user_name' => $this->user_name,
                    ':user_password_hash' => $this->user_password_hash,
                    ':user_activation_hash' => $this->user_activation_hash,
                    ':user_access_level' => $this->user_access_level));

                $count = $sth->rowCount();

                if ($count == 1) {

                    $this->user_id = $this->db->lastInsertId();

                    // send a verification email
                    /* if ($this->sendConfirmationEmail()) {

                      // when mail has been send successfully
                      $this->messages[] = FEEDBACK_ACCOUNT_SUCCESSFULLY_CREATED;
                      $this->registration_successful = true;
                      return true;

                      } else {

                      // delete this users account immediately, as we could not send a verification email
                      // the row (which will be deleted) is identified by PDO's lastinserid method (= the last inserted row)
                      // @see http://www.php.net/manual/en/pdo.lastinsertid.php

                      $sth = $this->db->prepare("DELETE FROM users WHERE user_id = :last_inserted_id ;");
                      $sth->execute(array(':last_inserted_id' => $this->db->lastInsertId() ));

                      $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_FAILED;

                      } */
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

    public function editUser($user_id, $forename, $surname, $email, $birthdate, $street, $place, $phone, $type, $leadertraining, $leader_since, $responsibility) {
        $sth = $this->db->prepare("UPDATE users SET 
                                user_contact_forename = :forename,
                                user_contact_surname = :surname,
                                user_email = :email,
                                user_contact_birthdate = :birthdate,
                                user_contact_street = :street,
                                user_contact_place = :place,
                                user_contact_phone = :phone,
                                user_access_level = :type,
                                user_leadertraining = :leadertraining,
                                user_leader_since = :leader_since,
                                user_responsibility = :responsibility
                        WHERE user_id = :user_id");
        $sth->execute(array(
            ':forename' => $forename,
            ':surname' => $surname,
            ':email' => $email,
            ':birthdate' => $birthdate,
            ':street' => $street,
            ':place' => $place,
            ':phone' => $phone,
            ':type' => $type,
            ':leadertraining' => $leadertraining,
            ':leader_since' => $leader_since,
            ':responsibility' => $responsibility,
            ':user_id' => $user_id));

        $count = $sth->rowCount();
        if ($count == 1) {
            return true;
        } else {
            $this->errors[] = $sth->errorInfo(); //FEEDBACK_NOTE_EDITING_FAILED;
            return false;
        }
    }

    /**
     * sendConfirmationEmail()
     * sends an email to the provided email address
     * @return boolean gives back true if mail has been sent, gives back false if no mail could been sent
     */
    private function sendConfirmationEmail() {

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
        $mail->AddAddress(Session::get("user_email"));
        $mail->Subject = EMAIL_VERIFICATION_SUBJECT;
        $mail->Body = "Der Benutzer $this->user_name wurde erfolgreich erstellt. Sein temporäres Passwort lautet $this->user_password.";

        if (!$mail->Send()) {

            $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_ERROR . $mail->ErrorInfo;
            return false;
        } else {

            $this->errors[] = FEEDBACK_VERIFICATION_MAIL_SENDING_SUCCESSFUL;
            return true;
        }
    }

    public function delete($user_id) {
        if ($user_id != $_SESSION['user_id']) {
            $sth = $this->db->prepare("DELETE FROM users WHERE user_id = :user_id");
            $sth->execute(array(
                ':user_id' => $user_id));

            $count = $sth->rowCount();

            if ($count == 1) {
                return true;
            } else {
                $this->errors[] = FEEDBACK_NOTE_DELETION_FAILED;
                return false;
            }
        }else{
            $this->errors[] = "Du kannst dich nicht selbst löschen!";
            return false;
        }
    }

}
