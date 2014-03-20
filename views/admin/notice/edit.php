
<script>
    $(function() {
        $('#notice_content').ckeditor();
        
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
                    $('.option_stufe').css({display: 'inline'});
                    $('.option_trupp').css({display: 'none'});
                    $('.option_stufe').first().attr("selected", "selected");
                    $('#selected_notice_group').attr("value", "2");
                    $('select[name=notice_group]').css({display: 'inline'});
                    break;
                case 'trupp':
                    $('.option_stufe').css({display: 'none'});
                    $('.option_trupp').css({display: 'inline'});
                    $('.option_trupp').first().attr("selected", "selected");
                    $('.selected_notice_group').attr("value", "4");
                    $('select[name=notice_group]').css({display: 'inline'});
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
    
    <h1>Onlineanschlag bearbeiten</h1>

    <?php if ($this->notice) { ?>

    <form id="create_notice_form" method="post" action="<?php echo URL; ?>admin/notice/editSave/<?php echo $this->notice->notice_id; ?>">

        <div class="input_group">
            <h3>Zeit Antreten</h3>
            <label>Datum</label>
            <input required class="datepicker" type="text" name="date_antreten" />

            <label>Zeit</label>
            <input required class="timepicker" type="text" name="time_antreten" value="<?php echo date("H:i", $this->notice->datetime_antreten); ?>" />
        </div>
        <div class="input_group">
            <h3>Zeit Abtreten</h3>
            <label>Datum</label>
            <input required class="datepicker" type="text" name="date_abtreten" />

            <label>Zeit</label>
            <input required class="timepicker" type="text" name="time_abtreten" value="<?php echo date("H:i", $this->notice->datetime_abtreten); ?>" />
        </div>
        <div class="input_group">
            <h3>Treffpunkt</h3>
            <label>Antreten</label>
            <input required type="text" name="place_antreten" value="<?php echo $this->notice->place_antreten; ?>" />
            <label>Abtreten</label>
            <input required type="text" name="place_abtreten" value="<?php echo $this->notice->place_abtreten; ?>" />
        </div>
        <div class="input_group">
            <h3 style="margin-bottom: 32px;">Betreffende Gruppe auwählen</h3>
            <select name="notice_level">
                <option value="abteilung">Abteilung</option>
                <option value="stufe">Stufe</option>
                <option value="trupp">Trupp</option>
                <option value="gruppe" disabled="disabled">Gruppe</option>
            </select>
            <select name="notice_group">
                <option value="2" class="option_stufe">Stufe Wölfe</option>
                <option value="3" class="option_stufe">Stufe Pfader</option>
                <option value="4" class="option_trupp">Meute Von Planta</option>                            
                <option value="5" class="option_trupp">Volk Pimpernuss</option>                            
                <option value="6" class="option_trupp">Trupp Aquila</option>                            
                <option value="7" class="option_trupp">Trupp Grisberg</option>
            </select>
            <input type="hidden" id="selected_notice_group" name="selected_notice_group" value="4" />
        </div>
        <div class="clearAll" style="width: 800px; padding-top: 20px;">
            <h3 style="margin-bottom: 10px;">Details</h3>
            <textarea id="notice_content" name="notice_content"><?php echo $this->notice->notice_content; ?></textarea>
        </div>
        <input style="margin-top: 20px;" type="submit" value='Speichern' autocomplete="off" style="margin-top: 20px;" />
    </form>
    <script>    
        $(window).load(function(){
            $('.datepicker[name=date_antreten]').val("<?php echo date("d.m.Y", $this->notice->datetime_antreten); ?>");
            $('.datepicker[name=date_abtreten]').val("<?php echo date("d.m.Y", $this->notice->datetime_abtreten); ?>");
            
            
            var notice_group_id = <?php echo $this->notice->notice_group_id; ?>;
            $('select[name=notice_group] option[value=' + notice_group_id + ']').attr("selected", "selected");
            $('#selected_notice_group').attr("value", notice_group_id);
            switch(notice_group_id){
                case 1: 
                    $('.option_stufe').css({display: 'none'});
                    $('.option_trupp').css({display: 'none'});
                    $('select[name=notice_level] option[value="abteilung"]').attr("selected", "selected");
                    $('select[name=notice_group]').css({display: 'none'});
                    break;
                case 2:
                    $('.option_trupp').css({display: 'none'});
                    $('select[name=notice_level] option[value="stufe"]').attr("selected", "selected");
                    break;
                case 3:
                    $('.option_trupp').css({display: 'none'});
                    $('select[name=notice_level] option[value="stufe"]').attr("selected", "selected");
                    break;
                case 4:
                    $('.option_stufe').css({display: 'none'});
                    $('select[name=notice_level] option[value="trupp"]').attr("selected", "selected");
                    break;
                case 5:
                    $('.option_stufe').css({display: 'none'});
                    $('select[name=notice_level] option[value="trupp"]').attr("selected", "selected");
                    break;
                case 6:
                    $('.option_stufe').css({display: 'none'});
                    $('select[name=notice_level] option[value="trupp"]').attr("selected", "selected");
                    break;
                case 7:
                    $('.option_stufe').css({display: 'none'});
                    $('select[name=notice_level] option[value="trupp"]').attr("selected", "selected");
                    break;
            }
        });
        
    </script>
    
    <?php } else { ?>
    
    <p>This news does not exist.</p>
    
    <?php } ?>
    
</div>    