<script>
    $(function() {
        //loadClickListener();

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

<style>
    #belegungsplan_calendar{
        width: 1350px;
        margin: 20px auto 100px;
        cursor: default;
    }
    #belegungsplan_calendar .month{
        display: inline-block;
        margin-bottom: 20px;
    }
    #belegungsplan_calendar .month_header{
        background-color: #CC3D18;
        text-align: center;
        color: #FFF;
        font-weight: bold;
        font-size: 18px;
        padding: 5px 0;
    }
    #belegungsplan_calendar .month_container{
        margin-top: 10px;
        padding: 0 10px;
    }
    #belegungsplan_calendar .month_container td.this_month{
        border: 1px solid #B1B1B1;
        background-color: #D3D3D3;
        width: 25px;
        height: 21px;
        text-align: center;
        padding-top: 4px;
        font-size: 14px;
        font-weight: bold;
    }
    #belegungsplan_calendar .month_container td.today{
        border: 1px solid #B1B1B1;
        background-color: #FFFFFF !important;
    }
    #belegungsplan_calendar .month_container td.reserved{
        border: 1px solid #BD9A9A;
        background-color: #E4BDBD;
    }
    #belegungsplan_calendar h3{
        border: none;
        margin-bottom: 10px;
    }
    #reserved_legend{
        width: 25px;
        height: 25px;
        border: 1px solid #BD9A9A;
        background-color: #E4BDBD;
    }
    #today_legend{
        width: 25px;
        height: 25px;
        border: 1px solid #B1B1B1;
        background-color: #FFFFFF;
    }
    #today_and_reserved_legend{
        width: 25px;
        height: 25px;
        border: 1px solid #BD9A9A;
        background-color: #FFFFFF;
    }
    .hatched{
        background-image: url('<?php echo URL; ?>public/images/hatched.png');
        background-size: 100%;
    }
    @media (max-width: 1480px) and (min-width: 960px) {
        #belegungsplan_calendar{
            width: 900px;
        }
    }
    @media (max-width: 960px) and (min-width: 740px) {
        #belegungsplan_calendar{
            width: 675px;
        }
    }
    @media (max-width: 740px) and (min-width: 0px) {
        #belegungsplan_calendar{
            width: 450px;
        }
    }
    @media (max-width: 500px) and (min-width: 0px) {
        #belegungsplan_calendar{
            width: 300px;
        }
        #belegungsplan_calendar th{
            
            font-size: 21px;
        }
        #belegungsplan_calendar .month_container td.this_month {
            width: 35px;
            height: 31px;
            font-size: 21px;
        }
        #belegungsplan_calendar .month_header{
            font-size: 23px;
            padding: 5px 0;
        }
    }
</style>
<div id="calendar_container" class="no_select">
    <div id="belegungsplan_calendar">
    <h3>Du möchtest unser Heim mieten? Dann melde dich bei unserer Heimverwaltung:</h3>
    <p>Denise Schubnell<br />
        Stationsstrasse 33<br />
        8544 Sulz-Rickenbach<br /><br />
        Telefon: 052 337 24 27<br />
        E-Mail: <a href="mailto:heimverwaltung@pfadiorion.ch?Subject=Heimreservation">heimverwaltung@pfadiorion.ch</a></p><br />
        <?php
        //load calendar
        if ($this->calendar) {
            echo $this->calendar;
        } else {
            echo 'Fehler beim laden';
        }
        ?>
    
    <table>
        <tr>
            <td>Besetzt:&nbsp;&nbsp;</td>
            <td id="reserved_legend" class="hatched"></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;Heute:&nbsp;&nbsp;</td>
            <td id="today_legend"></td>
            <td style="padding-top: 3px;">&nbsp;&nbsp;/&nbsp;&nbsp;</td>
            <td id="today_and_reserved_legend" class="hatched"></td>
        </tr>
    </table>
    </div>
</div>