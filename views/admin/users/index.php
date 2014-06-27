
<script>
    $(function() {

        $('.delete_button').on('click', function(event) {
            event.preventDefault();
            var elem = $(this);
            if (confirm('Den Benutzer "' + elem.parent().parent().find('.user_name').text() + '" wirklich löschen?')) {
                $.post(elem.attr('href'))
                        .done(function(data) {
                            if (data === 'done') {
                                $.notify('User wurde erfolgreich gelöscht!', 'success');
                                elem.parent().parent().hide(500);
                            } else {
                                $.notify(data, 'error');
                            }
                        });
            }
        });
        $('.edit_button').on('click', editUser);

        function editUser(event) {
            event.preventDefault();
            var elem = $(this).parent().parent();

            elem.children().each(function(i) {
                if ($(this).hasClass('edittext')) {
                    $(this).addClass('editing');
                    $(this).html('<input type="text" name="' + $(this).attr('class').split(' ')[1] + '" value="' + $(this).text() + '" />');

                } else if ($(this).hasClass('editdropdown')) {
                    var obj = $(this);
                    obj.addClass('editing');
                    $.post('<?php echo URL; ?>admin/users/getUserTypes', {selected: $(this).text()})
                            .done(function(data) {
                                obj.html(data);
                            });
                } 
            });

            elem.on('change', 'input, select', function() {
                $(this).addClass('valueChanged');
            });

            $(this).text('Save');
            $(this).off('click');
            $(this).on('click', saveChanges);
        }

        function saveChanges(event) {
            event.preventDefault();
            var elem = $(this).parent().parent();

            var user_data = {
                forename: elem.find('.user_contact_forename input').val(),
                surname: elem.find('.user_contact_surname input').val(),
                email: elem.find('.user_email input').val(),
                birthdate: elem.find('.user_contact_birthdate input').val(),
                street: elem.find('.user_contact_street input').val(),
                place: elem.find('.user_contact_place input').val(),
                phone: elem.find('.user_contact_phone input').val(),
                type: elem.find('.description :selected').val(),
                leadertraining: elem.find('.user_leadertraining input').val(),
                leader_since: elem.find('.user_leader_since input').val(),
                responsibility: elem.find('.user_responsibility input').val()
            };

            if (elem.find('.valueChanged').length > 0) {
                $.post($(this).attr('href'), user_data).done(function(data) {
                    if (data === 'done') {
                        $.notify('Gespeichert', 'success');
                    } else {
                        $.notify(data, 'error');
                    }
                });
            } else {
                $.notify('Es wurden keine Daten geändert', 'info');
            }

            elem.children().each(function(i) {
                if ($(this).hasClass('edittext') && $(this).hasClass('editing')) {
                    $(this).removeClass('editing');
                    $(this).html($(this).children().first().val());
                } else if ($(this).hasClass('editdropdown') && $(this).hasClass('editing')) {
                    $(this).removeClass('editing');
                    $(this).html($(this).find(':selected').text());
                } else {

                }
            });

            $(this).text('Edit');
            $(this).off('click');
            $(this).on('click', editUser);
        }
    });
</script>
<style>
    #user_list .form_gourp{
        display:inline-block;
    }
    #user_list input{
        min-width: 0;
        width: 100%;
        margin:0;
        height: 55px;
    }
    #user_list select{   
        width: 100%;     
        margin: 0;
        padding: 5px;
        height: 55px
    }
    #user_list td.editing{
        padding: 0 !important;
    }
    #user_list td.editing input{
        margin-bottom: -23px;
    }
</style>

<div class="content">

    <?php
    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">' . $error . '</div>';
        }
    }
    ?>

    <h1 style="clear: both;padding-top: 50px;">Alle Backend User</h1>
    <table id="user_list" class="list">
        <?php if ($this->users) { ?>
            <thead>
            <th>Benutzername</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>E-Mail</th>
            <th>Geb. Datum</th>
            <th>Strasse</th>
            <th>Wohnort</th>
            <th>Telefon</th>
            <th>Typ</th>
            <th>Ausbildung</th>
            <th>Leiter seit</th>
            <th>Zuständikeit</th>
            <th>Aktiviert</th>
            <th colspan="2">Funktionen</th>
            </thead>
            <tbody>
                <?php
                foreach ($this->users as $key => $value) {
                    echo '<tr id="user_' . $value->user_id . '">
                            <td class="noedit user_name">' . $value->user_name . '</td>
                            <td class="edittext user_contact_forename">' . $value->user_contact_forename . '</td>
                            <td class="edittext user_contact_surname">' . $value->user_contact_surname . '</td>
                            <td class="edittext user_email">' . $value->user_email . '</td>
                            <td class="edittext user_contact_birthdate">' . $value->user_contact_birthdate . '</td>
                            <td class="edittext user_contact_street">' . $value->user_contact_street . '</td>
                            <td class="edittext user_contact_place">' . $value->user_contact_place . '</td>
                            <td class="edittext user_contact_phone">' . $value->user_contact_phone . '</td>
                            <td class="editdropdown description">' . $value->description . '</td>
                            <td class="edittext user_leadertraining">' . $value->user_leadertraining . '</td>
                            <td class="edittext user_leader_since">' . $value->user_leader_since . '</td>
                            <td class="edittext user_responsibility">' . $value->user_responsibility . '</td>';
                    if ($value->user_active == 1) {
                        echo '<td class="noedit">Ja</td>';
                    } else {
                        echo '<td>Nein</td>';
                    }
                    echo '<td><a class="edit_button" href="' . URL . 'admin/users/edit/' . $value->user_id . '">Edit</a></td>
                    <td><a class="delete_button" href="' . URL . 'admin/users/delete/' . $value->user_id . '">Delete</a></td>
                    </tr>';
                }
            } else {

                echo 'Fehler!';
            }
            ?>
        </tbody>
    </table>

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

                    echo '<input type="text" name="user_password" value="' . $randomString . '" />'
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

</div>