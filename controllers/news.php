<?php

class News extends Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {

        $this->view->news_list = $this->model->showAllNews();
        $this->view->notices = $this->model->showRecentNotices();
        $this->view->events = $this->model->showRecentEvents();
        $this->view->recent_downloads = $this->model->getRecentDownloads(); 
        $this->view->reservation = $this->model->showRecentReservations();
        $this->view->render('news/index');
    }

    function kalender() {
        $this->view->calendar = $this->draw_calendar(date('n'), date('o'));
        $this->view->render('news/kalender');
    }
    
    function downloads(){
        $this->view->recent_downloads = $this->model->getRecentDownloads(); 
        $this->view->archived_downloads = $this->model->getArchivedDownloads(); 
        $this->view->render('news/downloads');
    }
    
    public function get_calendar(){
        echo $this->draw_calendar($_POST['month'], $_POST['year']);
    }

    public function draw_calendar($month, $year) {

         $calendar = '<h1>Kalender</h1><h2>'.$this->replaceMonthName(date('n', mktime(0, 0, 0, $month, 1, $year))).' '.date('o', mktime(0, 0, 0, $month, 1, $year)).'</h2>'
                 . '<div class="calendar_button" id="goto_today" data-month="'.date('n').'" data-year="'.date('o').'">Heute</div>'
                 . '<div class="calendar_button" id="goto_prev_month" data-month="'.
                 date('n', mktime(0, 0, 0, ($month - 1), 1, $year)).'" data-year="'.
                 date('o', mktime(0, 0, 0, ($month - 1), 1, $year)).'">'
                 . '</div><div class="calendar_button" id="goto_next_month" data-month="'.
                 date('n', mktime(0, 0, 0, ($month + 1), 1, $year)).'" data-year="'.
                 date('o', mktime(0, 0, 0, ($month + 1), 1, $year)).'"></div><a href="'.URL.'news"><div class="calendar_button" id="go_back_to_news">Zurück</div></a>';
         
        /* draw table */
        $calendar .= '<table id="event_table" cellspacing="0" cellpadding="0"><thead><tr>
                <td>Montag</td>
                <td>Dienstag</td>
                <td>Mittwoch</td>
                <td>Donnserstag</td>
                <td>Freitag</td>
                <td>Samstag</td>
                <td>Sonntag</td>
            </tr>
        </thead>
        <tbody>';

        /* days and weeks vars now ... */
        $today = date('j');
        $prev_month = date('t', mktime(0, 0, 0, ($month - 1), 1, $year));
        $next_month = date('t', mktime(0, 0, 0, ($month + 1), 1, $year));
        $running_day = date('N', mktime(0, 0, 0, $month, 0, $year));
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $days_in_this_week = 1;
        $day_counter = 0;

        /* row for week one */
        $calendar.= '<tr class="event_row">';

        /* print "blank" days until the first of the current week */
        for ($x = ($prev_month - $running_day + 1); $x <= $prev_month; $x++) {
            $calendar.= '<td class="last_month"><span class="event_detail_link">' . $x . '</span></td>';
            $days_in_this_week++;
        }
        
        if ($running_day == 7) {
            $calendar.= '</tr><tr class="event_row">';
            $running_day = 0;
        }

        /* keep going with days.... */
        for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {

            $calendar.= $day_counter + 1 == $today && $month == date('n') && $year == date('o')
                    ? '<td class="this_month today">' : '<td class="this_month">';

            /* add in the day number */
            $calendar.= $day_counter == 0 ? '<span class="event_detail_link">' . $list_day . '. ' . $this->replaceMonthName(date('n', mktime(0, 0, 0, $month, 1, $year))) . '</span>' : '<span class="event_detail_link">' . $list_day . '</span>';

            /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! * */
            foreach($this->model->getEvents(mktime(0, 0, 0, $month, ($day_counter + 1), $year)) as $event){
                if($event->all_day_event == 1){
                    $calendar.= '<span class="all_day_event">'.$event->event_name.'</span>';
                }else{
                    $calendar.= '<span class="timed_event"><b>'.date("G:i", $event->event_date).'</b><span class="timed_event_name"> '.$event->event_name.'</span></span>';
                }
            }

            $calendar.= '</td>';
            if ($running_day == 6) {
                $calendar.= '</tr>';
                if (($day_counter + 1) != $days_in_month) {
                    $calendar.= '<tr class="calendar-row">';
                }
                $running_day = -1;
                $days_in_this_week = 0;
            }
            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        }

        /* finish the rest of the days in the week */
        if ($days_in_this_week < 8) {
            $calendar.= '<td class="next_month"><span class="event_detail_link">1. ' . $this->replaceMonthName(date('n', mktime(0, 0, 0, $month + 1, 1, $year))) . '</span></td>';
            for ($x = 2; $x <= (8 - $days_in_this_week); $x++) {
                $calendar.= '<td class="next_month"><span class="event_detail_link">' . $x . '</span></td>';
            }
        }

        /* final row */
        $calendar.= '</tr></tbody></table>
    <table style="margin: 40px 0 0 20px;">
        <tr>
            <td>Ganztägige Events:&nbsp;&nbsp;</td>
            <td id="all_day_event_legend">1<span id="all_day_event_cont">Pfadi</span></td>
            <td style="padding-left: 30px;">Events mit Zeitangabe:&nbsp;&nbsp;</td>
            <td id="simple_event_legend">1<span id="timed_event_cont"><b>14:00</b> Pfadi</span></td>
            <td style="padding-left: 30px;">Heute:&nbsp;&nbsp;</td>
            <td id="today_legend">1</td>
        </tr>
    </table>';

        /* all done, return result */
        return $calendar;
    }

    public function show_notice($notice_id) {
        $notice = $this->model->showNotice($notice_id)[0];
        echo '<div class="overlay">
        <section class="modal rounded">
        <a class="closeModal" href="close_notice"></a>
        <h2>' . $this->replaceWeekday(date("N", $notice->datetime_antreten)) . ' den ' . date("d.m.Y", $notice->datetime_antreten) . '</h2>
        <h4 style="font-size: 22px;display: inline-block; width: 50%">Antreten</h4><h4 style="font-size: 22px;display: inline-block; width: 50%">Abtreten</h4><br />
        <span style="display: inline-block; width: 49%">' . date("H:i", $notice->datetime_antreten) . ' Uhr, ' . $notice->place_antreten . '</span>
        <span style="display: inline-block; width: 49%">' . date("H:i", $notice->datetime_abtreten) . ' Uhr, ' . $notice->place_abtreten . '</span><br />
        <h4 style="font-size: 22px;margin-top: 20px;">Details</h4>' . $notice->notice_content . '
        </section>
        </div>';
    }
    
    public function show_event($event_id) {
        $event = $this->model->showEvent($event_id)[0];
        echo "<div class='overlay'>" .
        "<section class='modal rounded'>" .
        "<a class='closeModal' href='close_notice'></a>" .
        "<h2>" . $event->event_name . "</h2>" .              
        "<p>" . $event->event_details . "</p>" .
        "</section>" .
        "</div>";
    }

    private function replaceWeekday($day) {
        switch ($day) {
            case "1": return "Montag";
            case "2": return "Dienstag";
            case "3": return "Mittwoch";
            case "4": return "Donnerstag";
            case "5": return "Freitag";
            case "6": return "Samstag";
            case "7": return "Sonntag";

            default:
                break;
        }
    }

    private function replaceMonthName($month) {
        switch ($month) {
            case "1": return "Januar";
            case "2": return "Februar";
            case "3": return "März";
            case "4": return "April";
            case "5": return "Mai";
            case "6": return "Juni";
            case "7": return "Juli";
            case "8": return "August";
            case "9": return "September";
            case "10": return "Oktober";
            case "11": return "November";
            case "12": return "Dezember";

            default:
                break;
        }
    }
}
