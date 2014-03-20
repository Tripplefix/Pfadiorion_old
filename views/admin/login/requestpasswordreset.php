<div class="content">

    <h1>Passwort Reset anfordern</h1>

    <?php 

    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }

    }

    ?>

    <!-- request password reset form box -->
    <form method="post" action="<?php echo URL; ?>login/requestpasswordreset_action" name="password_reset_form">
        <label for="password_reset_input_username">
            Gib deinen Benutzernamen an und du erhälst eine Email mit weiteren Anweisungen:
        </label>
        <input id="password_reset_input_username" class="password_reset_input" type="text" name="user_name" required />
        <input type="submit"  name="request_password_reset" value="Passwort zurücksetzen" />
    </form>
    
</div>