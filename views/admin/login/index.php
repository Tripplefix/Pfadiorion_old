<div class="content">

    <h1>Login</h1>

    <?php 

    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }

    }

    ?>
    
    <form action="<?php echo URL; ?>admin/login/login" method="post">
        <p style="color: red; font-weight: bold;">Dies ist nur die Beta-Seite, Änderungen hier werden auf der Hauptseite nicht übernommen!</p>
            <label>Benutzername</label>
            <input type="text" name="user_name" required />
            
            <label>Passwort</label>
            <input type="password" name="user_password" required />
            
            <input type="checkbox" name="user_rememberme" style="float: left; min-width: 0; margin: 3px 10px 15px 0;" />
            <label style="float:left; min-width: 0; font-size: 12px; color: #888;">Eingeloggt bleiben (für 2 Wochen)</label>
                                    
            <input type="submit" style="float: none; clear: both;" />           
            
    </form>    
    <!-- <a href="<?php echo URL; ?>admin/login/requestpasswordreset">Passwort vergessen</a> -->
    
</div>