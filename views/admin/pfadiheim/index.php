<script>
    $(function() {
        $(".datepicker").datepicker().datepicker("option", "dateFormat", "dd.mm.yy");
        $('#reservation_content').ckeditor();

        $('.edit_button').click(function(event) {
            event.preventDefault();
        });

        $('.delete_button').click(function(event) {
            event.preventDefault();
            var elem = $(this);

            $.post(elem.attr('href'))
                    .done(function(data) {
                        $.notify("Reservation wurde erfolgreich gelöscht!", "success");
                        elem.parent().parent().hide(500);
                    });
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
    <?php if (Session::get('user_access_level') == 5): ?>
        <h1 id="create_notice" style="cursor: pointer;">Neue Reservation</h1>
        <?php
        if ($this->errors) {

            foreach ($this->errors as $value) {
                echo '<h2>' . $value . '</h2>';
            }
        }
        ?>

        <form id="create_reservation_form" method="post" action="<?php echo URL; ?>admin/pfadiheim/create" style="width: 60%;">
            <div class="input_group">
                <h3>Start</h3>
                <label>Datum</label>
                <input required class="datepicker" type="text" name="date_start" />

                <label>Zeit</label>
                <input required class="timepicker" type="text" name="time_start" />
            </div>
            <div class="input_group">
                <h3>Ende</h3>
                <label>Datum</label>
                <input required class="datepicker" type="text" name="date_end" />

                <label>Zeit</label>
                <input required class="timepicker" type="text" name="time_end" />
            </div>
            <div class="input_group">
                <h3>Mieter</h3>
                <input style="margin-top: 31px;" required type="text" name="tenant" />
            </div>
            <div class="clearAll" style="width: 800px; padding-top: 20px;">
                <h3>Details</h3>
                <textarea id="reservation_content" name="details" ></textarea>
            </div>
            <input style="margin-top: 20px;"  style="float:left;" type="submit" value='Eintragen' autocomplete="off" />
        </form>


        <h1 style="clear: both;padding-top: 50px;">Alle Reservationen</h1>
        <table class="list">
            <?php if ($this->reservation_list) { ?>
                <thead>
                <th>start</th>
                <th>ende</th>
                <th>Mieter</th>
                <th>Details</th>
                <th colspan="2">Funktionen</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->reservation_list as $key => $value) {
                        echo '<tr>';
                        echo '<td>am ' . date("d.m.Y", $value->date_start) . ' um ' . $value->time_start . '</td>';
                        echo '<td>am ' . date("d.m.Y", $value->date_end) . ' um ' . $value->time_end . '</td>';
                        echo '<td>' . $value->tenant . '</td>';
                        echo '<td>' . $value->details . '</td>';
                        echo '<td><a class="edit_button" href="' . URL . 'admin/pfadiheim/edit/' . $value->reservation_id . '">Edit</a></td>';
                        echo '<td><a class="delete_button" href="' . URL . 'admin/pfadiheim/delete/' . $value->reservation_id . '">Delete</a></td>';
                        echo '</tr>';
                    }
                } else {

                    echo 'Es gibt momentan keine Reservationen!';
                }
                ?>
            </tbody>
        </table>
    <?php endif; ?>    
    <?php if (Session::get('user_access_level') < 5): ?>
        <p>Zugriff verweigert!</p>
    <?php endif; ?>    

</div>     