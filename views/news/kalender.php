<script>
    $(function() {
        $('#calendar_container').on('click', '#goto_today', function() {
            $.post('<?php echo URL; ?>news/get_calendar', {month: $(this).data("month"), year: $(this).data("year")})
                    .done(function(result) {
                        $('#calendar_container').html(result);
                    });
        });

        $('#calendar_container').on('click', '#goto_prev_month', function() {
            $.post('<?php echo URL; ?>news/get_calendar', {month: $(this).data("month"), year: $(this).data("year")})
                    .done(function(result) {
                        $('#calendar_container').html(result);
                    });
        });

        $('#calendar_container').on('click', '#goto_next_month', function() {
            $.post('<?php echo URL; ?>news/get_calendar', {month: $(this).data("month"), year: $(this).data("year")})
                    .done(function(result) {
                        $('#calendar_container').html(result);
                    });
        });
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
</div>