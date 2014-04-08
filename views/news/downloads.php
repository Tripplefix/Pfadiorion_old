<script>
    var colorCont = new Array('#DD4722', '#3FA750', '#FFE000', '#4C26E0');
    $(function() {
        console.log(colorCont[Math.floor(Math.random() * colorCont.length)]);
        var i = 0;
        $('.download_element').each(function() {
            if (i >= colorCont.length)
                i = 0;
            $(this).css({
                borderTop: "5px solid " + colorCont[i]
            });
            i++;
        });
    });
</script>

<style>
    #download_container{
        width: 1650px;
        height: 1000px;
        margin: 50px auto;
    }
    #download_container h1{
        font-size: 40px;
    }
    .download_element{
        display: inline-block;
        vertical-align: top;
        width: 430px;
        height: 300px;
        margin: 50px 50px 0 0;
        padding: 10px 30px 20px;
        box-shadow: 5px 4px 7px -7px #292929, -1px 1px 8px -3px #292929;
        border-radius: 4px;
        overflow: hidden;
    }
    .download_element label{
        font-weight: bold;
    }

    .download_preview, .download_details{
        display: inline-block;
        vertical-align: top;
    }    
    .download_preview{
        width: 170px;
        height: 240px;
        box-shadow: 0px 0px 8px -1px #292929;
        background-repeat: no-repeat;
        background-size: 100%;
    }
    .download_details{
        padding: 5px 20px;
        width: 220px;
    }

    .download_button{
        margin: 20px auto;
        padding: 4px 15px;
        width: 100px;
        text-align: center;
        color: #FFF;
        font-weight: bold;
        font-size: 21px;
        background-color: #CC3D18;
        border-radius: 5px;
        cursor: pointer;
        transition: none;
        display: block;
    }
    .download_button:hover{
        background-color: #DA512D;
        border-bottom: 4px solid #CC3D18;
        padding-bottom: 0px;
        text-decoration: none;
    }
    .download_button:active{
        background-color: #CC3D18;
    }

    #download_archive li{
        list-style: none;
    }
    #download_archive a{
        text-decoration: underline;
        margin: 5px;
        display: block;
    }
</style>

<div id="download_container">
    <h1>Aktuelle Downloads</h1>
    <?php
//load downloads
    if ($this->recent_downloads) {
        foreach ($this->recent_downloads as $key => $value) {
            echo '<div class="download_element pdf">
                    <h2>' . $value->download_title . ' (' . strtoupper($value->download_file_type) . ')</h2>
                    <div class="download_preview" style="background-image: url(\'' . URL . 'public/download/thumbs/' . $value->download_file_name . '_thumb.png\'); ">
                    </div><div class="download_details">
                        <label>Info</label>
                        <p>' . $value->download_info . '</p>
                        <label>Dateiname</label>
                        <p>' . $value->download_file_name . '</p>
                        <label>Dateigrösse</label>
                        <p>' . $value->download_size . '</p>
                        <a class="download_button no_select" href="' . URL . 'public/download/' . $value->download_file_name . '">Download</a>
                    </div>
                </div>';
        }
    } else {
        echo 'Momentan gibt es keine aktuellen Downloads';
    }
    ?>
    <br /><br /><br /><br />
    <h1>Download Archiv</h1><br />
    <ul id="download_archive">
        <?php
//load downloads
        if ($this->archived_downloads) {
            foreach ($this->archived_downloads as $key => $value) {
                echo '<li><a class="no_select" href="' . URL . 'public/download/' . $value->download_file_name . '">' . $value->download_file_name . ' (' . $value->download_size . ')</a></li>';
            }
        } else {
            echo 'Keine archivierten Downloads vorhanden';
        }
        ?>
    </ul>
</div>