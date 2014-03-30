<script>
    $(function() {

        $('#changeemail').on('submit', function(evt) {
            evt.preventDefault();
            $.post($(this).attr('action'), $(this).serialize())
                    .done(function(data) {
                        if(data === "done"){                            
                            $.notify("E-Mail Adresse erfolgreich geändert!", "success");
                        }else{
                            $.notify(data, "error");
                        }
                    });
        });
    });
</script>


<div class="content">

    <h1>&Auml;ndere deine E-Mail Adresse</h1>

    <?php
    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">' . $error . '</div>';
        }
    }
    ?>

    <form id="changeemail" action="<?php echo URL; ?>admin/login/edituseremail_action" method="post">

        <label>Neue E-Mail Adresse:</label>
        <input type="text" name="user_email" required />

        <label>Dein Passwort</label>
        <input type="password" name="user_password" required />

        <input type="submit" value="Submit" />
    </form>

</div>