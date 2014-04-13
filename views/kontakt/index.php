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
                case 'Heimverwaltung': window.location.href = '<?php echo URL; ?>pfadiheim#google_maps_overlay';
                    break;
                case 'Elternrat':
                    $.post("<?php echo URL; ?>kontakt/elternrat").done(function(data) {
                        $('#contact_container').html("<h2>Elternrat</h2>" + data);
                        addEvents();
                    });
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
            <li>Elternrat</li>
            <li class="last">Heimverwaltung</li>
        </ul>
    </nav>
</div>
<div id="contact_container">
</div>