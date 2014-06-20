<?php

class Kontakt extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->abteilungsleiter = $this->model->getContactsByType(5);
        $this->view->truppleiter = $this->model->getContactsByType(3);
        $this->view->gruppenführer = $this->model->getContactsByType(2);
        $this->view->hilfsleiter = $this->model->getContactsByType(1);

        $this->view->render('kontakt/index');
    }

    function abteilungsleiter() {
        echo $this->loadContactCards($this->model->getContactsByType(5));
    }

    function truppleiter() {
        echo $this->loadContactCards($this->model->getContactsByType(3));
    }

    function gruppenfuehrer() {
        echo $this->loadContactCards($this->model->getContactsByType(2));
    }

    function hilfsleiter() {
        echo $this->loadContactCards($this->model->getContactsByType(1));
    }

    function heimverwaltung() {
        echo ""; //$this->model->getContactsByType(5);
    }

    function elternrat() {
        echo $this->loadContactCards($this->model->getContactsByType(7));
    }

    private function loadContactCards($info) {

        $result = '';
        foreach ($info as $key => $value) {
            $result .= '<div class="profileinfo" style="border-color: ' . $value->user_color . '">';
            if ($value->user_has_avatar == 0) {
                $result .= '<img class="profilepicture" src="' . URL . 'public/avatars/missing.jpg" />';
            } else {
                $result .= '<img class="profilepicture" src="' . URL . 'public/avatars/' . $value->user_id . '.jpg" />';
            }
            
            
            $full_name = $value->user_name != '' 
                    ? '<div class="full_name">' . $value->user_contact_forename . ' ' . $value->user_contact_surname . ' v/o&nbsp;' . $value->user_name . '</div>'
                    : '<div class="full_name">' . $value->user_contact_forename . ' ' . $value->user_contact_surname . '</div>'; 


            $result .= $full_name . '<div class="leader_type">' . $value->user_responsibility . '</div>
                    <div class="show_more_details">Kontaktdaten</div>
                    <div class="contact_info">
                        <h3>Kontaktdaten</h3>
                        <table cellspacing="0">';
            
            if($value->user_contact_phone != ""){
                $result .= '<tr>
                                <td class="font_bold">Telefon</td>
                                <td>' . $value->user_contact_phone . '</td>
                            </tr>';
            }
            if($value->user_email != ""){
                $result .= '<tr>
                                <td class="font_bold">E-Mail</td>
                                <td><a href="mailto:' . $value->user_email . '">' . $value->user_email . '</a></td>
                            </tr>';
            }
            if($value->user_contact_street != "" && $value->user_contact_place != ""){
                $result .= '<tr>
                                <td class="font_bold">Adresse</td>
                                <td>' . $value->user_contact_street . '
                                <br />' . $value->user_contact_place . '</td>
                            </tr>';
            }
            if($value->user_contact_phone == "" 
                    && $value->user_email == "" 
                    && $value->user_contact_street == "" 
                    && $value->user_contact_place == ""){
                $result .= '<tr>
                                <td class="font_bold" colspan="2">Es sind keine Daten vorhanden</td>
                            </tr>';
            }
            if($value->user_leadertraining != ""){
                $result .= '<tr style="height: 10px;"><td></td></tr><tr style="height: 10px;"><td style="border-top: 1px solid #b9b9b9;" colspan="2"></td></tr>
                            <tr>
                                <td class="font_bold">Ausbildung</td>
                                <td>' . $value->user_leadertraining . '</td>
                            </tr>';
            }
            if($value->user_leader_since != ""){
                $result .= '<tr>
                                <td class="font_bold">Leiter seit</td>
                                <td>' . $value->user_leader_since . '</td>
                            </tr>';
            }
            $result .= '</table></div></div>';
        }
        return $result;
    }

    function impressum() {
        $this->view->render('kontakt/impressum');
    }

}
