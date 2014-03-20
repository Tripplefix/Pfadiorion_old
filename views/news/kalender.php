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
    <!-- <table id="event_table" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <td>Mo</td>
                <td>Di</td>
                <td>Mi</td>
                <td>Do</td>
                <td>Fr</td>
                <td>Sa</td>
                <td>So</td>
            </tr>
        </thead>
        <tbody>
            <tr class="event_row">
                <td class="last_month"><span class="event_detail_link">24</span></td>
                <td class="last_month"><span class="event_detail_link">25</span></td>
                <td class="last_month"><span class="event_detail_link">26</span></td>
                <td class="last_month"><span class="event_detail_link">27</span></td>
                <td class="last_month"><span class="event_detail_link">28</span></td>
                <td class="this_month today"><span class="event_detail_link">1. März</span><span class="timed_event"><b>14:00</b> Pfadiübung</span></td>
                <td class="this_month"><span class="event_detail_link">2</span></td>
            </tr>
            <tr class="event_row">
                <td class="this_month"><span class="event_detail_link">3</span></td>
                <td class="this_month"><span class="event_detail_link">4</span></td>
                <td class="this_month"><span class="event_detail_link">5</span></td>
                <td class="this_month"><span class="event_detail_link">6</span></td>
                <td class="this_month"><span class="event_detail_link">7</span><span class="all_day_event">Rolf's birthday</span></td>
                <td class="this_month"><span class="event_detail_link">8</span><span class="timed_event"><b>14:00</b> Pfadiübung</span></td>
                <td class="this_month"><span class="event_detail_link">9</span></td>
            </tr>
            <tr class="event_row">
                <td class="this_month"><span class="event_detail_link">10</span></td>
                <td class="this_month"><span class="event_detail_link">11</span></td>
                <td class="this_month"><span class="event_detail_link">12</span><span class="timed_event"><b>10:00</b> BiBi Zmorge</span><span class="timed_event"><b>19:00</b> Filmabend</span></td>
                <td class="this_month"><span class="event_detail_link">13</span></td>
                <td class="this_month"><span class="event_detail_link">14</span></td>
                <td class="this_month"><span class="event_detail_link">15</span><span class="timed_event"><b>14:00</b> Pfadiübung</span></td>
                <td class="this_month"><span class="event_detail_link">16</span></td>
            </tr>
            <tr class="event_row">
                <td class="this_month"><span class="event_detail_link">17</span></td>
                <td class="this_month"><span class="event_detail_link">18</span></td>
                <td class="this_month"><span class="event_detail_link">19</span></td>
                <td class="this_month"><span class="event_detail_link">20</span></td>
                <td class="this_month"><span class="event_detail_link">21</span></td>
                <td class="this_month"><span class="event_detail_link">22</span><span class="all_day_event">Sternprüfungen</span></td>
                <td class="this_month"><span class="event_detail_link">23</span><span class="all_day_event">Sternprüfungen</span></td>
            </tr>
            <tr class="event_row">
                <td class="this_month"><span class="event_detail_link">24</span></td>
                <td class="this_month"><span class="event_detail_link">25</span></td>
                <td class="this_month"><span class="event_detail_link">26</span></td>
                <td class="this_month"><span class="event_detail_link">27</span></td>
                <td class="this_month"><span class="event_detail_link">28</span></td>
                <td class="this_month"><span class="event_detail_link">29</span><span class="timed_event"><b>14:00</b> Pfadiübung</span></td>
                <td class="this_month"><span class="event_detail_link">30</span></td>
            </tr>
            <tr class="event_row">
                <td class="this_month"><span class="event_detail_link">31</span></td>
                <td class="next_month"><span class="event_detail_link">1. April</span><span class="all_day_event">Haha</span></td>
                <td class="next_month"><span class="event_detail_link">2</span></td>
                <td class="next_month"><span class="event_detail_link">3</span></td>
                <td class="next_month"><span class="event_detail_link">4</span></td>
                <td class="next_month"><span class="event_detail_link">5</span><span class="timed_event"><b>14:00</b> Pfadiübung</span></td>
                <td class="next_month"><span class="event_detail_link">6</span></td>
            </tr>
        </tbody>
    </table> -->
</div>