<div class="content">
    
    <h1>Eintrag bearbeiten</h1>

    <?php if ($this->news) { ?>
    
    <form method="post" action="<?php echo URL; ?>admin/news/editSave/<?php echo $this->news->news_id; ?>" style="width: 60%;">
        <label>Ändere den Titel hier:</label>
        <input type="text" name="news_title" autocomplete="off" value="<?php echo $this->news->news_title; ?>" />  
        <label>Ändere den Inhalt hier:</label>     
        <textarea id="articleBody" name="news_content" ><?php echo $this->news->news_content; ?></textarea>
        <script>
            $( '#articleBody' ).ckeditor();
        </script>
        <input type="submit" value='Ändern' style="margin-top: 20px;" />
    </form>
    
    <?php } else { ?>
    
    <p>This news does not exist.</p>
    
    <?php } ?>
    
</div>    