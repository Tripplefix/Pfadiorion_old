<div class="content">

    <h1>Change your username</h1>

    <?php 

    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }

    }

    ?>

    <form action="<?php echo URL; ?>login/editusername_action" method="post">

        <label>New username</label>
        <input type="text" name="user_name" required />

        <label>Your password (to prove it's really YOU):</label>
        <input type="password" name="user_password" required />

        <input type="submit" value="Submit" />
    </form>
    
</div>