<script>
    $(function() {
        $('#update_calendar').on('click', function() {
            $.post('<?php echo URL ?>admin/dashboard/updateCalendar', function(data) {
                alert(data);
            });
        });
    });
    
    $(window).on('load', function(){
       $('#kadermanager_frame').attr('src', 'http://pfadiorion.kadermanager.de/calendar/widget_iframe_events'); 
    });
</script>
<style>
    #news_stream{
        width: 80%;
        display: inline-block;
        vertical-align: top;
    }
    #news_sidebar{
        width: 20%;
        display: inline-block;
        vertical-align: top;
    }
    #kadermanager_widget{
        padding: 20px 5px;
        border: 1px solid #393939;
    }
</style>
<div class="content">
    <h1>Dashboard</h1>

    <?php
    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">' . $error . '</div>';
        }
    }
    ?>

    <section id="news_stream">
        <h2>Leiter-News</h2>
        <h3 style="font-style: italic">in Arbeit</h3>
        
    </section><aside id="news_sidebar">
        <h3><a href="http://pfadiorion.kadermanager.de/" target="blank" style="font-size:18px;text-decoration:none;">Anstehende Events</a></h3>

        <!-- KADERMANAGER.DE EVENT-LISTE -->
        <div id="kadermanager_widget">
            <div style="text-align:left;">
                <div>
                    » <a href="http://pfadiorion.kadermanager.de/calendar/monthly" target="blank">Kalender</a>
                    · <a href="http://pfadiorion.kadermanager.de/player" target="blank">Teilnehmer</a>
                </div>
            </div>

            <iframe id="kadermanager_frame" style="width:100%; height: 300px;border: none;padding:0px;margin:5px 0px 10px 0px;allowtransparency:true;" 
                    frameBorder="0" scrolling="auto"></iframe>
        </div>
        <!-- /KADERMANAGER.DE EVENT-LISTE -->
        
        <h3>Fotos</h3>
        <p style="font-style: italic">in Arbeit</p>

        <h3>Dokumente</h3>
        <p style="font-style: italic">in Arbeit</p>
    </aside>
</div>
