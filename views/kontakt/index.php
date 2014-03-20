<div id="contact_container">
    
    
                <?php
//load orion members      
                if ($this->contacts) {
                    foreach ($this->contacts as $key => $value) {
                        //echo "<li><a class='notice_link' href='" . URL . "news/show_notice/" . $value->notice_id . "'>" . $value->description . "</a></li>";
                    }
                } else {
                    echo 'Ups, da ist wohl etwas schief gelaufen!';
                }
                ?>
    
</div>