<?php

class Redirect extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $id = $_GET['id'];
        
        //TODO save links in database
        $links = [
            "http://www.pfadi.ch",
            "http://www.scout.ch",
            "http://www.pfadiwinti.ch",
            "http://www.scout.ch/de/pfadialltag/stufenarbeit/neues-pfadiprofil",
            "http://www.scout.ch/de/pfadialltag/stufenarbeit/woelfe",
            "http://www.scout.ch/de/pfadialltag/stufenarbeit/pfadis",
            "http://www.scout.ch/de/pfadialltag/stufenarbeit/pios",
            "http://www.scout.ch/de/pfadialltag/stufenarbeit/rover",
            "http://www.eps-asds.ch",
            "http://www.pfadi.ch", "http://www.silverscout.ch",
            "http://www.jugendundsport.ch/internet/js/de/home/lager_trekking/uebersicht.html",
            "http://www.technix-online.ch/Inhalt.html",
            "http://www.hajk.ch",
            "http://pfadiorion.ch/public/download/Anmeldeformular%20Pfadi%20Orion.pdf"
        ];
        
        if(isset($links[$id])){            
            header ('HTTP/1.1 301 Moved Permanently');
            header("Location: " . $links[$id]); 
            header("Connection: close"); 
        }else{
            header('location: ' . URL . 'index');
        }
    }
}
