<div class="content">
    <h1 id="create_notice" style="cursor: pointer;">Wilkommen</h1>
    <p>Du hast dich gerade zum ersten Mal angemeldet und musst daher noch deine Email-Adresse angeben und ein neues Passwort setzen</p>

    <form id="create_notice_form" method="post" action="<?php echo URL; ?>admin/login/updateuser" style="width: 60%;">
        <table style="float:left;">
            <tr>
                <td>
                    <h3>Email Adresse</h3>
                    <input required type="text" name="user_email" />
                </td>
                <td style="padding-left: 20px;">
                    <h3>Neues Passwort</h3>
                    <input required type="password" pattern=".{6,}" name="user_password" />
                </td>
            </tr>
            <tr>
                <td>
        <input type="submit" value='Eintragen' autocomplete="off" style="margin-top: 20px;" />
                </td>
            </tr>
        </table>        
    </form>
</div>