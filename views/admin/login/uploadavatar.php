<script>
$(function(){
    /*$('#avatar_form').on('submit', function(evt){
        evt.preventDefault();
        $.post($(this).attr('action'), $(this).serialize())
                .done(function(data){
                    console.log("done: " + data);
                });
    });*/
});
</script>
<div class="content">

    <h1>Profilbild hochladen</h1>

    <?php 

    if (isset($this->errors)) {

        foreach ($this->errors as $error) {
            echo '<div class="system_message">'.$error.'</div>';
        }

    }

    ?>
    
    <form id="avatar_form" action="<?php echo URL; ?>admin/login/uploadavatar_action" method="post" enctype="multipart/form-data">
        <label for="avatar_file">Wähle ein Profilbild von deiner Fotosammlung aus (wird auf 400x400px skaliert):</label>
        <input type="file" name="avatar_file" required />
        <!-- max size 5 MB (as many people directly upload high res pictures from their digicams) -->
        <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
        <input name="submit" type="submit" value="Bild hochladen" />
    </form>
    
</div>