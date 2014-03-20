
<script>
    $(function() {
        var is_notice_form_hidden = false;
        $(".datepicker").val("<?php echo date("d.m.Y", strtotime("next saturday")) ?>");
        $('#notice_content').ckeditor();

        $('#create_notice').click(function() {

            if (is_notice_form_hidden) {
                is_notice_form_hidden = false;
                $('#create_notice_form').show(500);
            } else {
                is_notice_form_hidden = true;
                $('#create_notice_form').hide(500);
            }
        });

        $('.edit_button').click(function(event) {
            //event.preventDefault();
        });

        $('#create_notice_form').submit(function(event) {
            
            $('td[data-group-id]').each(function(){
                if($(this).attr("data-group-id") === $('#selected_notice_group').val()){
                    event.preventDefault();
                    $.notify("Ein aktueller Eintrag für diese Gruppe ist bereits vorhanden!", "warn");
                }
            });
        });
         // Stop form from submitting normally
         //event.preventDefault();
         //console.log($(this).serialize());
         
         /*$.post($(this).attr('action'), $(this).serialize())
         .done(function(data) {
         $.notify("Onlineanschlag wurde erfolgreich erfasst!", "success");
         $('#create_notice_form').delay(1000).hide(1500);
         });
         });*/

        /*$('.edit_button').click(function(event) {
         event.preventDefault();
         
         $.post($(this).attr('href'))
         .done(function(data) {
         $.notify("Onlineanschlag wird geladen!", "info");
         });
         });*/

        $('.delete_button').click(function(event) {
            event.preventDefault();
            var elem = $(this);

            $.post(elem.attr('href'))
                    .done(function(data) {
                        $.notify("Onlineanschlag wurde erfolgreich gelöscht!", "success");
                        elem.parent().parent().hide(500);
                    });
        });

        $('.option_stufe').css({display: 'none'});

        $('select[name=notice_level]').change(function(event) {
            console.log($('select[name=notice_level] option:selected').attr("value"));
            switch ($('select[name=notice_level] option:selected').attr("value")) {
                case 'abteilung':
                    $('.option_stufe').css({display: 'none'});
                    $('.option_trupp').css({display: 'none'});
                    $('select[name=notice_group]').css({display: 'none'});
                    $('#selected_notice_group').attr("value", "1");
                    break;
                case 'stufe':
                    $('.option_stufe').css({display: ''});
                    $('.option_trupp').css({display: 'none'});
                    $('.option_stufe').first().attr("selected", "selected");
                    $('#selected_notice_group').attr("value", "2");
                    $('select[name=notice_group]').css({display: ''});
                    break;
                case 'trupp':
                    $('.option_stufe').css({display: 'none'});
                    $('.option_trupp').css({display: ''});
                    $('.option_trupp').first().attr("selected", "selected");
                    $('.selected_notice_group').attr("value", "4");
                    $('select[name=notice_group]').css({display: ''});
                    break;
                case 'gruppe':
                    break;
                default:
                    break;
            }
        });

        $('select[name=notice_group]').change(function() {
            $('#selected_notice_group').attr("value", $('select[name=notice_group] option:selected').attr("value"));
        });

    });
</script>

<style>
    .input_group{
        //display: inline-block;
        float: left;
        margin-right: 25px;
    }
    .clearAll{
        clear: both;
    }
</style>

<div class="content">
    <?php
    if ($this->errors) {

        foreach ($this->errors as $value) {
            echo '<h2>' . $value . '</h2>';
        }
    }
    ?>

    <h1 id="create_notice" style="cursor: pointer;">Erstelle einen neuen Anschlag</h1>

    <form id="create_notice_form" method="post" action="<?php echo URL; ?>admin/notice/create">

        <div class="input_group">
            <h3>Zeit Antreten</h3>
            <label>Datum</label>
            <input required class="datepicker" type="text" name="date_antreten" />

            <label>Zeit</label>
            <input required class="timepicker" type="text" name="time_antreten" value="14:00" />
        </div>
        <div class="input_group">
            <h3>Zeit Abtreten</h3>
            <label>Datum</label>
            <input required class="datepicker" type="text" name="date_abtreten" />

            <label>Zeit</label>
            <input required class="timepicker" type="text" name="time_abtreten" value="17:00" />
        </div>
        <div class="input_group">
            <h3>Treffpunkt</h3>
            <label>Antreten</label>
            <input required type="text" name="place_antreten" value="Pfadiheim" />
            <label>Abtreten</label>
            <input required type="text" name="place_abtreten" value="Pfadiheim" />
        </div>
        <div class="input_group">
            <h3 style="margin-bottom: 32px;">Betreffende Gruppe auwählen</h3>
            <select name="notice_level">
                <option value="abteilung">Abteilung</option>
                <option value="stufe">Stufe</option>
                <option selected="selected" value="trupp">Trupp</option>
                <option value="gruppe" disabled="disabled">Gruppe</option>
            </select>
            <select name="notice_group">
                <option value="2" class="option_stufe">Stufe Wölfe</option>
                <option value="3" class="option_stufe">Stufe Pfader</option>
                <option value="4" class="option_trupp" selected="selected">Meute Von Planta</option>                            
                <option value="5" class="option_trupp">Volk Pimpernuss</option>                            
                <option value="6" class="option_trupp">Trupp Aquila</option>                            
                <option value="7" class="option_trupp">Trupp Grisberg</option>
            </select>
            <input type="hidden" id="selected_notice_group" name="selected_notice_group" value="4" />
        </div>
        <div class="clearAll" style="width: 800px; padding-top: 20px;">
            <h3 style="margin-bottom: 10px;">Details</h3>
            <textarea id="notice_content" name="notice_content">Mitnehmen: Zvieri und Ztrinke</textarea>
        </div>
        <input style="margin-top: 20px;" type="submit" value='Eintragen' />
    </form>

    <h1 style="clear: both;padding-top: 50px;">Liste aller aktuellen Anschläge</h1>
    <table class="list">
        <?php if ($this->notice_list) { ?>
            <thead>
            <th style="min-width: 112px;">Für Gruppe</th>
            <th>Antreten</th>
            <th>Abtreten</th>
            <th style="min-width: 120px;">Erfasst von</th>
            <th colspan="2">Funktionen</th>
            </thead>
            <tbody>
                <?php
                foreach ($this->notice_list as $key => $value) {
                    echo '<tr>';
                    echo '<td data-group-id=' . $value->notice_group_id . '>' . $value->notice_group . '</td>';
                    echo '<td>am ' . date("d.m.Y", $value->datetime_antreten) . ' um ' . date("H:i", $value->datetime_antreten) . ' Uhr</td>';
                    echo '<td>am ' . date("d.m.Y", $value->datetime_abtreten) . ' um ' . date("H:i", $value->datetime_abtreten) . ' Uhr</td>';
                    echo '<td>' . $value->user_name . '</td>';
                    echo '<td><a class="edit_button" href="' . URL . 'admin/notice/edit/' . $value->notice_id . '">Edit</a></td>';
                    echo '<td><a class="delete_button" href="' . URL . 'admin/notice/delete/' . $value->notice_id . '">Delete</a></td>';
                    echo '</tr>';
                }
            } else {

                echo 'Keine aktuellen Anschläge vorhanden!';
            }
            ?>
        </tbody>
    </table>

    <h1 style="clear: both;padding-top: 50px;">Liste aller alten Anschläge</h1>
    <table class="list">
        <?php if ($this->outdated_notice_list) { ?>
            <thead>
            <th style="min-width: 112px;">Für Gruppe</th>
            <th>Antreten</th>
            <th>Abtreten</th>
            <th style="min-width: 120px;">Erfasst von</th>
            <th colspan="2">Funktionen</th>
            </thead>
            <tbody>
                <?php
                foreach ($this->outdated_notice_list as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . $value->notice_group . '</td>';
                    echo '<td>am ' . date("d.m.Y", $value->datetime_antreten) . ' um ' . date("H:i", $value->datetime_antreten) . ' Uhr</td>';
                    echo '<td>am ' . date("d.m.Y", $value->datetime_abtreten) . ' um ' . date("H:i", $value->datetime_abtreten) . ' Uhr</td>';
                    echo '<td>' . $value->user_name . '</td>';
                    echo '<td><a class="edit_button" href="' . URL . 'admin/notice/edit/' . $value->notice_id . '">Edit</a></td>';
                    echo '<td><a class="delete_button" href="' . URL . 'admin/notice/delete/' . $value->notice_id . '">Delete</a></td>';
                    echo '</tr>';
                }
            } else {

                echo 'Keine alten Anschläge vorhanden!';
            }
            ?>
        </tbody>
    </table>

</div>