<script>
    $(function() {
        loadClickListener();

        function loadClickListener() {
            $('#goto_today').click(function() {
                $.ajax({
                    type: "POST",
                    url: '<?php echo URL; ?>news/get_calendar',
                    data: {month: $(this).data("month"), year: $(this).data("year")}
                }).done(function(result) {
                    $('#calendar_container').html(result);
                    loadClickListener();
                });
            });

            $('#goto_prev_month').click(function() {
                $.ajax({
                    type: "POST",
                    url: '<?php echo URL; ?>news/get_calendar',
                    data: {month: $(this).data("month"), year: $(this).data("year")}
                }).done(function(result) {
                    $('#calendar_container').html(result);
                    loadClickListener();
                });
            });

            $('#goto_next_month').click(function() {
                $.ajax({
                    type: "POST",
                    url: '<?php echo URL; ?>news/get_calendar',
                    data: {month: $(this).data("month"), year: $(this).data("year")}
                }).done(function(result) {
                    $('#calendar_container').html(result);
                    loadClickListener();
                });
            });
        }
    });
</script>

<div id="calendar_container" class="no_select">

    <?php
    //load calendar
    if ($this->calendar) {
        echo $this->calendar;
    } else {
        echo 'Fehler beim laden';
    }
    ?>
    <style>
        #all_day_event_legend{
            width: 100px;
            height: 80px;
            padding: 5px;
            white-space: nowrap;
            border: 1px solid #c8c8c8;
            background-color: #EBEBEB;
        }
        #all_day_event_legend #all_day_event_cont{
            border: 1px solid #D69407;
            background-color: #FCC360;
            display: block;
            color: #000;
            cursor: pointer;
            overflow: hidden;
        }
        #simple_event_legend{
            width: 100px;
            height: 80px;
            padding: 5px;
            white-space: nowrap;
            border: 1px solid #c8c8c8;
            background-color: #EBEBEB;
        }
        #simple_event_legend #timed_event_cont{
            font-weight: normal;
            color: #A00000;
            display: block;
            cursor: pointer;
            overflow: hidden;
        }
        #simple_event_legend #timed_event_cont b{
            color: #A00000;        
        }
        #today_legend{
            width: 100px;
            height: 80px;
            padding: 5px;
            white-space: nowrap;
            border: 1px solid #c8c8c8;
            background-color: #EBEBEB;
            font-weight: bold;
            border-top: 4px solid black !important;
            display: block;
        }
    </style>
    <table style="margin: 40px 0 0 20px;">
        <tr>
            <td>Ganztägige Events:&nbsp;&nbsp;</td>
            <td id="all_day_event_legend">1<span id="all_day_event_cont">Pfadi</span></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Events mit Zeitangabe:&nbsp;&nbsp;</td>
            <td id="simple_event_legend">1<span id="timed_event_cont"><b>14:00</b> Pfadi</span></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Heute:&nbsp;&nbsp;</td>
            <td id="today_legend">1</td>
        </tr>
    </table>
</div>