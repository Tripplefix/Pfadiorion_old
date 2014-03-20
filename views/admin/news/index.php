<div class="content">

    <h1>Erstelle einen neuen Beitrag</h1>

    <form method="post" action="<?php echo URL; ?>admin/news/create" style="width: 60%;">
        <h3>Titel</h3>
        <input type="text" name="news_title" />         
        <h3>Inhalt</h3>
        <textarea id="news_content" name="news_content" ></textarea>
        <script>
            $('#news_content').ckeditor();
        </script>
        <input type="submit" value='Eintragen' autocomplete="off" style="margin-top: 20px;" />
    </form>

    <h1 style="margin-top: 50px;">Liste deiner Beiträge</h1>
    <table class="list">
        <?php if ($this->news_list_user) { ?>

            <thead>
            <th>Titel</th>
            <th>Autor</th>
            <th colspan="2">Funktionen</th>
            </thead>
            <tbody>

                <?php
                foreach ($this->news_list_user as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . $value->news_title . '</td>';
                    echo '<td>' . $value->user_name . '</td>';
                    echo '<td><a href="' . URL . 'admin/news/edit/' . $value->news_id . '">Edit</a></td>';
                    echo '<td><a href="' . URL . 'admin/news/delete/' . $value->news_id . '">Delete</a></td>';
                    echo '</tr></tbody>';
                }
            } else {

                echo 'Du hast noch keine Einträge geschrieben. Dann wirds langsam zeit!';
            }
            ?>
    </table>

    <?php if (Session::get('user_access_level') == 5): ?>

    <h1 style="margin-top: 50px;">Liste aller Beiträge</h1>
    <table class="list">
        <?php if ($this->news_list_all) { ?>

            <thead>
            <th>Titel</th>
            <th>Autor</th>
            <th colspan="2">Funktionen</th>
            </thead>
            <tbody>

                <?php
                foreach ($this->news_list_all as $key => $value) {
                    echo '<tr>';
                    echo '<td>' . $value->news_title . '</td>';
                    echo '<td>' . $value->user_name . '</td>';
                    echo '<td><a href="' . URL . 'admin/news/edit/' . $value->news_id . '">Edit</a></td>';
                    echo '<td><a href="' . URL . 'admin/news/delete/' . $value->news_id . '">Delete</a></td>';
                    echo '</tr></tbody>';
                }
            } else {

                echo 'Es wurden sonst noch keine Beiträge geschrieben';
            }
            ?>
    </table>
    
    <?php endif; ?>    

</div>