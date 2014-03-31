<style>
    #contact_group_chooser{
        float: left;
        margin-top: 100px;
        margin-right: 40px;
        font-size: 18px;
        font-weight: bold;
    }
    #contact_group_chooser ul{
        list-style: none;
    }
    #contact_group_chooser li{
        padding: 10px 25px;
        width: 180px;
        border-top: 4px solid #FFF;
        background-color: #DD4722;
        color: #FFF;
        cursor: pointer;
        transition: all .2s;
    }
    #contact_group_chooser li:hover{
        background-color: #FFF;
        padding-left: 20px;
        color: #DD4722;
    }


    #contact_container{
        margin-left: calc(50% - 700px);
        display: inline-block;
        width: 75%;
        max-width: 1280px;
    }
    .profileinfo{
        display: inline-block;
        border-top: 5px solid #FFE000;
        padding: 30px;
        padding-bottom: 0;
        background-color: #FFF;
        box-shadow: 5px 4px 7px -7px #292929, -1px 1px 8px -3px #292929;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 15px;
        width: 230px;
        height: 390px;
        text-align: center;
        margin-bottom: 40px;
        margin-right: 20px;
    }

    .profilepicture{
        width: 150px;
        height: 150px;
        border-radius: 200px;
        margin-bottom: 20px;
    }

    .full_name{
        font-size: 28px;
    }
    .leader_type{
        margin-top: 20px; 
        font-size: 20px;
    }
    .show_more_details{
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
    .show_more_details:hover{
        height: 21px;
        background-color: #D65331;
        border-bottom: 2px solid #cc3d18;
    }
    .show_more_details:active{
        height: 22px;
        padding-top: 6px;
        background-color: #C2330E;
        border-top: 2px solid #B82E0B;
        border-bottom: none;
    }

    .contact_info{
        display: none;
        text-align: left;
    }

    .contact_info h3{
        margin-bottom: 15px;
        margin-top: -15px !important;
    }

    .contact_info .font_bold{
        font-weight: bold;
    }

    .contact_info tr td:nth-child(2){
        padding-left: 8px;
    }
    wbr:after { content: "\00200B" }

    @media (max-width: 1480px) and (min-width: 1280px) {
        #contact_container{
            margin-left: calc(50% - 600px);
            display: inline-block;
            width: 930px;
        }
    }
    @media (max-width: 1280px) and (min-width: 960px) {
        #contact_container{
            width: 620px;
            margin-left: 20px;
        }
    }
    @media (max-width: 960px) and (min-width: 670px) {

        #contact_group_chooser{
            float: none;
            margin: 20px calc(50% - 319px);
        }
        #contact_group_chooser li{
            padding: 15px 25px;
            width: 160px;
            display: inline-block;
        }
        #contact_group_chooser li:hover{
            background-color: #FFF;
            padding-left: 25px;
            color: #DD4722;
        }

        #contact_container{
            width: 620px;
            margin-left: calc(50% - 300px);
        }
    }
    @media (max-width: 670px) and (min-width: 0px) {
        #contact_group_chooser{
            margin: 20px 0;
            width: 100%;
        }
        #contact_group_chooser li{
            padding: 15px 4%;
            width: calc((76% - 8px) / 3);
            display: inline-block;
        }		
        #contact_group_chooser li:hover{
            background-color: #FFF;
            padding-left: 4%;
            color: #DD4722;
        }
        #contact_container{
            width: 290px;
            margin-left: calc(50% - 145px);
        }
    }
    @media (max-width: 550px) and (min-width: 0px) {
        #contact_group_chooser li{
            width: calc((84% - 4px) / 2);
        }
    }
</style>
<script>
    $(function() {
        $.post("<?php echo URL; ?>kontakt/abteilungsleiter").done(function(data) {
            $('#contact_container').html("<h2>Abteilungsleiter</h2>" + data);
            addEvents();
        });
        $('#contact_group_chooser li').on('click', function() {
            switch ($(this).text()) {
                case 'Abteilungsleiter':
                    $.post("<?php echo URL; ?>kontakt/abteilungsleiter").done(function(data) {
                        $('#contact_container').html("<h2>Abteilungsleiter</h2>" + data);
                        addEvents();
                    });
                    break;
                case 'Truppleiter':
                    $.post("<?php echo URL; ?>kontakt/truppleiter").done(function(data) {
                        $('#contact_container').html("<h2>Truppleiter</h2>" + data);
                        addEvents();
                    });
                    break;
                case 'Gruppenführer':
                    $.post("<?php echo URL; ?>kontakt/gruppenfuehrer").done(function(data) {
                        $('#contact_container').html("<h2>Gruppenführer</h2>" + data);
                        addEvents();
                    });
                    break;
                case 'Hilfsleiter':
                    $.post("<?php echo URL; ?>kontakt/hilfsleiter").done(function(data) {
                        $('#contact_container').html("<h2>Hilfsleiter</h2>" + data);
                        addEvents();
                    });
                    break;
                case 'Heimverwaltung':
                    break;
                case 'Elternrat':
                    break;
            }
        });

    });

    function addEvents() {
        $('.show_more_details').on('click', function() {
            var elem = $(this).parent();
            if ($(this).text() === "Schliessen") {
                elem.find('.profilepicture').slideDown(200);
                elem.find('.contact_info').css({display: 'none'});
                $(this).text("Kontaktdaten");
            } else {
                elem.find('.profilepicture').slideUp(200);
                $(this).text("Schliessen");
                elem.find('.contact_info').fadeIn(200);
            }
        });
    }
</script>
<div id="contact_group_chooser">
    <nav>
        <ul>
            <li>Abteilungsleiter</li>
            <li>Truppleiter</li>
            <li>Gruppenführer</li>
            <li>Hilfsleiter</li>
            <li>Heimverwaltung</li>
            <li class="last">Elternrat</li>
        </ul>
    </nav>
</div>
<div id="contact_container">
</div>