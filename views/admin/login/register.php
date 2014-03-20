<div class="content">

    <h1>Registrieren</h1>
    <p>funcktioniert nicht!</p>

    <?php
    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">' . $error . '</div>';
        }
    }
    ?>

    <!-- register form -->
    <form method="post" action="<?php echo URL; ?>login/register_action" name="registerform">
        <p>Hier kannst du deinen Account für das Backend der Orion-homepage mithilfe des Resgistrierungscodes, den du bekommen hast freischalten.</p>

        <!-- the user name input field uses a HTML5 pattern check -->
        <label for="login_input_username">
            Username
            <span style="display: block; font-size: 14px; color: #999;">(only letters and numbers, 2 to 64 characters)</span>
        </label>
        <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />

        <!-- the email input field uses a HTML5 email type check -->
        <label for="login_input_email">
            User's email
            <span style="display: block; font-size: 14px; color: #999;">(please provide a <span style="text-decoration: underline; color: mediumvioletred;">real email address</span>, you'll get a verification mail with an activation link)</span>
        </label>
        <input id="login_input_email" class="login_input" type="email" name="user_email" required />

        <label for="login_input_password_new">
            Password (min. 6 Zeichen!)
            <span class="login-form-password-pattern-reminder">
                Please note: using a long sentence as a password is much much safer then something like "!c00lPa$$w0rd"). Have a look on
                <a href="http://security.stackexchange.com/questions/6095/xkcd-936-short-complex-password-or-long-dictionary-passphrase">
                    this interesting security.stackoverflow.com thread
                </a>.            
            </span>
        </label>
        <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />  

        <label for="login_input_password_repeat">Repeat password</label>
        <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />

        <label for="login_input_registration_code">Registrierungscode
            <span style="display: block; font-size: 14px; color: #999;">(Diesen Code solltest du von deinem Abteilungsleiter bekommen haben)</span>
        </label>
        <input id="login_input_registration_code" class="login_input" type="text" name="login_input_registration_code" required autocomplete="off" />

        <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
        <!-- to avoid weird with-slash-without-slash issues: simply always use the URL constant here -->
        <img src="<?php echo URL; ?>login/showCaptcha" />

        <label>Please enter those characters</label>
        <input type="text" name="captcha" required />

        <input type="submit"  name="register" value="Anfordern" />

    </form>

</div>