<script>
    $(function() {
        /*$('#insert_donwload').on('submit', function(event) {
            event.preventDefault();

            $.post($(this).attr('action'), $(this).serialize())
                    .done(function(data) {
                        console.log(data);
                    });
        });*/
        $('.delete_button').on('click', function(event){
            event.preventDefault();
            
            $.post($(this).attr('href')).done(function(data){
                if(data === 'done'){
                    $.notify("Download wurde erfolgreich gelöscht!", "success");
                    $(this).parent().parent().hide(500);
                }else{
                    $.notify("Error: " + data, "error");
                }
            });
        });
    });
</script>
<style>
    form .input_group{
        display: inline-block;
        vertical-align: top;
        margin-right: 40px;
    }
    form label{
        font-weight: bold;
    }
    form textarea{
        width: 200px;
        height: 80px;
    }
</style>
<div class="content">
    <h1>Erstelle einen neuen Beitrag</h1>

    <form id="insert_donwload" method="post" action="<?php echo URL; ?>admin/news/create_download" enctype="multipart/form-data">       
        <div class="input_group">
            <label for="dl_title">Titel</label>
            <input id="dl_title" name="dl_title" type="text" required />
        </div>
        <div class="input_group">
            <label for="dl_title">Beschreibung</label>
            <textarea id="dl_info" name="dl_info" required maxlength="200"></textarea>
        </div>
        <div class="input_group">
            <label for="dl_file">Datei</label>
            <p style="font-size: 12px;">(Erlaubt: .pdf, .doc(x), .xls(x), .zip)</p>
            <input id="dl_file" name="dl_file" type="file" required />
        </div>
        <input type="submit" value='Eintragen' style="margin-top: 20px;" />
    </form>

    <h1 style="margin-top: 50px;">Liste aller aktuellen Downloads</h1>
    <table class="list">
        <?php if ($this->recent_downloads) { ?>

            <thead>
            <th>Titel</th>
            <th>Info</th>
            <th>Dateiname</th>
            <th>Grösse</th>
            <th>Dateityp</th>
            <th colspan="2">Funktionen</th>
            </thead>
            <tbody>

                <?php
                foreach ($this->recent_downloads as $key => $value) {
                    echo '<tr>
                    <td>' . $value->download_title . '</td>
                    <td>' . $value->download_info . '</td>
                    <td><a class="download_button no_select" href="' . URL . 'public/download/' . $value->download_file_name . '">'
                    . $value->download_file_name . '</a></td>
                    <td>' . $value->download_size . '</td>
                    <td>' . $value->download_file_type . '</td>
                    <td><a href="' . URL . 'admin/news/archive_download/' . $value->download_id . '">Archive</a></td>
                    <td><a class="delete_button" href="' . URL . 'admin/news/delete_download/' . $value->download_id . '">Delete</a></td>
                    </tr></tbody>';
                }
            } else {

                echo 'keine aktuellen Downloads vorhanden';
            }
            ?>
    </table>

    <h1 style="margin-top: 50px;">Liste aller archivierten Downloads</h1>
    <table class="list">
        <?php if ($this->archived_downloads) { ?>

            <thead>
            <th>Titel</th>
            <th>Info</th>
            <th>Dateiname</th>
            <th>Grösse</th>
            <th>Dateityp</th>
            <th></th>
            </thead>
            <tbody>

                <?php
                foreach ($this->archived_downloads as $key => $value) {
                    echo '<tr>
                    <td>' . $value->download_title . '</td>
                    <td>' . $value->download_info . '</td>
                    <td>' . $value->download_file_name . '</td>
                    <td>' . $value->download_size . '</td>
                    <td>' . $value->download_file_type . '</td>
                    <td><a class="delete_button" href="' . URL . 'admin/news/delete_download/' . $value->download_id . '">Delete</a></td>
                    </tr></tbody>';
                }
            } else {

                echo 'keine archvierten Downloads vorhanden';
            }
            ?>
    </table> 

</div>