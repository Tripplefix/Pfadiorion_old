<script>
    $(function() {
        $('#profilepicture').on('click', function() {
            window.location.href = '<?php echo URL; ?>admin/login/uploadavatar';
        });

        $('#show_more_details').on('click', function() {
            if ($(this).text() === "Schliessen") {
                $('#profilepicture').slideDown(200);
                $('#contact_info').css({display: 'none'});
                $(this).text("Kontaktdaten");
            } else {
                $('#profilepicture').slideUp(200);
                $(this).text("Schliessen");
                $('#contact_info').fadeIn(200);
            }
        });

        $('#change_profileinfo').on('submit', function(evt) {
            evt.preventDefault();
            console.log($(this).attr('action'));
            $.post($(this).attr('action'), $(this).serialize())
                    .done(function(data) {
                        console.log(data);
                        if (data === "error") {
                            $.notify("Fehler beim Speichern", "error");
                        } else {
                            $.notify("Speichern erfolgreich", "success");
                        }
                    });
        });
    });
</script>
<style>

    #profileinfo{
        display: inline-block;
        border-top: 5px solid #FFE000;
        padding: 50px;
        padding-bottom: 0;
        background-color: #FFF;
        box-shadow: 5px 4px 7px -7px #292929, -1px 1px 8px -3px #292929;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 15px;
        width: 250px;
        height: 500px;
        text-align: center;
        margin-bottom: 40px;
    }

    #profilepicture{
        width: 250px;
        height: 250px;
        border-radius: 200px;
        cursor: pointer;
        margin-bottom: 40px;
    }

    #full_name{
        font-size: 28px;
    }
    #leader_type{
        margin-top: 20px; 
        font-size: 20px;
    }
    #show_more_details{
        width: 120px;
        height: 23px;
        color: #FFF;
        font-size: 14px;
        font-weight: bold;
        padding-top: 7px;
        border-radius: 4px;               
        background-color: #cc3d18;
        cursor: pointer;
        margin: 30px auto;
    }
    #show_more_details:hover{
        height: 21px;
        background-color: #D65331;
        border-bottom: 2px solid #cc3d18;
    }
    #show_more_details:active{
        height: 22px;
        padding-top: 6px;
        background-color: #C2330E;
        border-top: 2px solid #B82E0B;
        border-bottom: none;
    }

    #change_profileinfo{
        display: inline-block;
        vertical-align: top;
        margin-left: 50px;
    }
    .form_group{
        display: inline-block;
        margin: 10px 20px 0 0;
        vertical-align: top;
    }
    #contact_info{
        text-align: left;
        line-height: 20px;
        font-size: 16px;
    }
    #contact_info h3{
        font-size: 24px;
        margin-top: 80px;
        margin-bottom: 20px;
    }
    #contact_info td{
        padding: 6px 15px 0 0;
    }
    .font_bold{
        font-weight: bold;
    }
</style>
<div class="content">

    <h1>Dein Profil</h1>
    <?php
    if (isset($this->errors)) {
        foreach ($this->errors as $error) {
            echo '<div class="system_message">' . $error . '</div>';
        }
    }
    ?>
    <h3>Vorschau:</h3>

    <div id="profileinfo">
        <?php if (Session::get('user_avatar_file') == ""): ?>
            <img id="profilepicture" src='<?php echo URL; ?>public/avatars/missing.jpg' /> 
        <?php else: ?> 
            <img id="profilepicture" src='<?php echo Session::get('user_avatar_file'); ?>' />
        <?php endif; ?>

        <div id="full_name"><?php echo $this->profile->user_contact_forename ?> <?php echo $this->profile->user_contact_surname ?>
            v/o&nbsp;<?php echo Session::get('user_name'); ?></div>
        <div id="leader_type"><?php echo $this->profile->user_responsibility ?></div>
        <div id="show_more_details">Kontaktdaten</div>


        <div id="contact_info">
            <h3>Kontaktdaten</h3>
            <table cellspacing="0">

                <?php if ($this->profile->user_contact_phone != ""): ?>
                    <tr>
                        <td class="font_bold">Telefon</td>
                        <td><?php echo $this->profile->user_contact_phone ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($this->profile->user_email != ""): ?>
                    <tr>
                        <td class="font_bold">E-Mail</td>
                        <td><?php echo $this->profile->user_email ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($this->profile->user_contact_street != "" && $this->profile->user_contact_place != ""): ?>
                    <tr>
                        <td class="font_bold">Adresse</td>
                        <td><?php echo $this->profile->user_contact_street ?>
                            <br /><?php echo $this->profile->user_contact_place ?></td>
                    </tr>
                <?php endif; ?>
                <?php
                if ($this->profile->user_contact_phone == "" 
                        && $this->profile->user_email == "" 
                        && $this->profile->user_contact_street == "" 
                        && $this->profile->user_contact_place == ""):
                    ?>
                    <tr>
                        <td class="font_bold" colspan="2">Es sind keine Daten vorhanden</td>
                    </tr>
                <?php endif; ?>
                <?php if ($this->profile->user_leadertraining != ""): ?>
                    <tr style="height: 10px;"><td></td></tr><tr style="height: 10px;"><td style="border-top: 1px solid #b9b9b9;" colspan="2"></td></tr>
                    <tr>
                        <td class="font_bold">Ausbildung</td>
                        <td><?php echo $this->profile->user_leadertraining ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($this->profile->user_leader_since != ""): ?>
                    <tr>
                        <td class="font_bold">Leiter seit</td>
                        <td><?php echo $this->profile->user_leader_since ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div> 
    <form id="change_profileinfo" action="<?php echo URL; ?>admin/login/saveprofilechanges">
        <h2>&Auml;ndere deine Angaben</h2>
        <h3>Allgemein</h3>
        <div class="form_group">
            <label for="forename">Vorname</label>
            <input id="forename" name="forename" type="text" required="required" value="<?php echo $this->profile->user_contact_forename ?>" />
        </div>
        <div class="form_group">
            <label for="surname">Nachname</label>
            <input id="surname" name="surname" type="text" required="required" value="<?php echo $this->profile->user_contact_surname ?>" />
        </div>
        <div class="form_group">
            <label for="birthdate">Geburtsdatum</label>
            <input id="birthdate" name="birthdate" class="datepicker" type="text" placeholder="tt.mm.jjjj" value="<?php echo $this->profile->user_contact_birthdate ?>" />
        </div>
        <br />
        <h3>Kontaktdaten</h3>
        <div class="form_group">
            <label for="street">Strasse & Nr.</label>
            <input id="street" name="street" type="text" value="<?php echo $this->profile->user_contact_street ?>" />
        </div>
        <div class="form_group">
            <label for="place">PLZ & Wohnort</label>
            <input id="place" name="place" type="text" value="<?php echo $this->profile->user_contact_place ?>" />
        </div>
        <div class="form_group">
            <label for="phone">Telefonnummer (Handy oder Festnetz)</label>
            <input id="phone" name="phone" type="text" value="<?php echo $this->profile->user_contact_phone ?>" />
        </div>
        <div class="form_group">
            <label for="email">E-Mail Adresse 
                <span style="font-size: 12px;">(wenn möglich <span style="font-style: italic;">pfadiname</span>@pfadiorion.ch verwenden)</span></label>
            <input id="email" name="email" type="text" value="<?php echo $this->profile->user_email ?>" />
        </div>
        <input type="submit" value="Speichern" />
    </form>
</div>