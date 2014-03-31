
<script>
    $(function() {

        $('.edit_button').click(function(event) {
            event.preventDefault();
        });

        $('.delete_button').click(function(event) {
            event.preventDefault();
            var elem = $(this);

            $.post(elem.attr('href'))
                    .done(function(data) {
                        $.notify("Onlineanschlag wurde erfolgreich gelöscht!", "success");
                        elem.parent().parent().hide(500);
                    });
        });
    });
</script>

<style>
    .input_group{
        display: inline-block;
        margin-right: 25px;
        vertical-align: top;
        margin-bottom: 20px;
    }
    .input_group label{
        font-weight: bold;
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

    <h1 id="create_event" style="cursor: pointer;">Erstelle einen neuen Event</h1>

    <form id="create_event_form" method="post" action="<?php echo URL; ?>admin/kalender/create">
        <div class="input_group">
            <label for="event_date">Event Datum</label>
            <input type="text" class="datepicker" required name="event_date" id="event_date" />
        </div>
        <div class="input_group">
            <label for="event_time">Startzeit</label>
            <input type="text" class="timepicker" required name="event_time" id="event_time" />
        </div>
        <div class="input_group">
            <label for="event_name">Event Name</label>
            <input type="text" required name="event_name" id="event_name" />
        </div>
        <div class="input_group">
            <label for="all_day_event">Ganztägiger Event?</label>
            <select name="all_day_event" id="all_day_event">
                <option value="1">Ja</option>
                <option value="0">Nein</option>
            </select>
        </div><br />
        <div class="input_group">
            <label for="event_details">Event Details</label>
            <textarea name="event_details" id="event_details" required maxlength="200" placeholder="max. 200 Zeichen" style="width: 400px;height: 150px;padding: 10px" ></textarea>
        </div><br />
        <input style="margin-top: 20px;" type="submit" value='Eintragen' />
    </form>

    <h1 style="clear: both;padding-top: 50px;">Liste aller Events</h1>
    <table class="list">
        <?php if ($this->event_list) { ?>
            <thead>
            <th style="min-width: 112px;">Event Datum</th>
            <th style="min-width: 112px;">Startzeit</th>
            <th>Event Name</th>
            <th>Event Details</th>
            <th>Ganztägig</th>
            <th style="min-width: 120px;">Erfasst von</th>
            <th colspan="2">Funktionen</th>
            </thead>
            <tbody>
                <?php
                foreach ($this->event_list as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . date("d.m.Y", $value->event_date) . '</td>';
                    echo '<td>' . date("G:i:s", $value->event_date) . '</td>';
                    echo '<td>' . $value->event_name . '</td>';
                    echo '<td>' . $value->event_details . '</td>';
                    if ($value->all_day_event == 1) {
                        echo '<td>Ja</td>';
                    } else {
                        echo '<td>Nein</td>';
                    }
                    echo '<td>' . $value->user_name . '</td>';
                    echo '<td><a class="edit_button" href="' . URL . 'admin/kalender/edit/' . $value->event_id . '">Edit</a></td>';
                    echo '<td><a class="delete_button" href="' . URL . 'admin/kalender/delete/' . $value->event_id . '">Delete</a></td>';
                    echo '</tr>';
                }
            } else {

                echo 'Keine Events vorhanden!';
            }
            ?>
        </tbody>
    </table>

</div>