
<script>
    $(function() {
        
        $('.delete_button').click(function(event) {
            event.preventDefault();
            var elem = $(this);

            $.post(elem.attr('href'))
                    .done(function(data) {
                        $.notify("User wurde erfolgreich gelöscht!", "success");
                        elem.parent().parent().hide(500);
                    });
        });
    });
</script>

<div class="content">

    <?php
    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">' . $error . '</div>';
        }
    }
    ?>
    
    <?php if (Session::get('user_access_level') == 5): ?>
        <h1 style="clear: both;padding-top: 50px;">Backend User hinzufügen</h1>

        <form method="post" action="<?php echo URL; ?>admin/users/create" style="width: 60%;">
            <table>
                <tr>
                    <td>
                        <h3>Benutzername</h3>
                        <input type="text" name="user_name" />   
                    </td>
                    <td>
                        <h3>Passwort</h3>
                        <?php
                        
                            //create random string as new password
                            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            $randomString = '';
                            $length = 10;
                            for ($i = 0; $i < $length; $i++) {
                                $randomString .= $characters[rand(0, strlen($characters) - 1)];
                            }
                            
                            echo '<input type="text" name="user_password" value="'.$randomString.'" />'
                        
                        ?>
                    </td>
                    <td style="padding-left: 10px;">
                        <h3>Berechtigungsstufe</h3>  
                        <select name="user_access_level">
                            <option value="1">Hilfsleiter</option>
                            <option value="2">Gruppenführer</option>
                            <option value="3">Truppleiter</option>
                            <option value="4">Stufenleiter</option>
                            <option value="5">Abteilungsleiter</option>
                        </select>                        
                    </td>
                </tr>
            </table>
            <input type="submit" value='Eintragen' style="margin-top: 20px;" />
        </form>
    
        <h1 style="clear: both;padding-top: 50px;">Alle Backend User</h1>
        <table class="list">
            <?php if ($this->users) { ?>
                <thead>
                <th>Benutzername</th>
                <th>Typ</th>
                <th>Aktiviert</th>
                <th>Funktionen</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->users as $key => $value) {
                        echo '<tr>';
                        echo '<td>' . $value->user_name . '</td>';
                        echo '<td>' . $value->user_type . '</td>';
                        if($value->user_active == 1){
                            echo '<td>Ja</td>';
                        }else{
                            echo '<td>Nein</td>';
                        }
                        echo '<td><a class="delete_button" href="' . URL . 'admin/users/delete/' . $value->user_id . '">Delete</a></td>';
                        echo '</tr>';
                    }
                } else {

                    echo 'Fehler!';
                }
                ?>
            </tbody>
        </table>
    
    <?php endif; ?>    

</div>