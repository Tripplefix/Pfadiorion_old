<?php

class Pfadiheim extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {

        $this->view->render('pfadiheim/index');
    }

    function details() {

        $this->view->render('pfadiheim/index');
    }

    function belegung() {
        $this->view->calendar = $this->draw_calendar(1, date('o'));
        $this->view->render('pfadiheim/belegungsplan');
    }

    private function draw_calendar($month, $year) {
        $calendar = '';

        for ($i = 0; $i < 12; $i++) {
            
            /* days and weeks vars now ... */
            $today = date('j');
            $running_month = $month + $i;
            $running_year = date('o', mktime(0, 0, 0, $running_month, 1, $year));
            $prev_month = date('t', mktime(0, 0, 0, ($running_month - 1), 1, $running_year));
            $next_month = date('t', mktime(0, 0, 0, ($running_month + 1), 1, $running_year));
            $running_day = date('N', mktime(0, 0, 0, $running_month, 0, $running_year));
            $days_in_month = date('t', mktime(0, 0, 0, $running_month, 1, $running_year));
            $days_in_this_week = 1;
            $day_counter = 0;
            
            $calendar .= '<div class="month">
                            <div class="month_header">
                                ' . $this->replaceMonthName(date('n', mktime(0, 0, 0, $running_month, 1, $running_year))) . ' '
                    . date('o', mktime(0, 0, 0, $running_month, 1, $running_year)) . '
                            </div>
                            <div class="month_container">';

            /* todo  */

            /* draw table */
            $calendar .= '<table id="event_table">
                        <thead>
                            <tr>
                                <th>Mo</th>
                                <th>Di</th>
                                <th>Mi</th>
                                <th>Do</th>
                                <th>Fr</th>
                                <th>Sa</th>
                                <th>So</th>
                            </tr>
                    </thead><tbody>';


            /* row for week one */
            $calendar.= '<tr>';

            /* print "blank" days until the first of the current week */
            for ($x = ($prev_month - $running_day + 1); $x <= $prev_month; $x++) {
                $calendar.= '<td class="last_month"></td>';
                $days_in_this_week++;
            }

            if ($running_day == 7) {
                $calendar.= '</tr><tr>';
                $running_day = 0;
            }

            /* keep going with days.... */
            for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
                $calendar.= '<td class="this_month';
                $calendar.= $day_counter + 1 == $today && $running_month == date('n') && $running_year == date('o') ? ' today' : '';
                 
                /* check if its reserved that day */
                if ($this->model->getBelegung(mktime(0, 0, 0, $running_month, ($day_counter + 1), $running_year)) > 0) {
                    $calendar.= ' reserved';
                }
                
                $calendar.= '">' . $list_day . '</td>';

                $calendar.= '';
                if ($running_day == 6) {
                    $calendar.= '</tr>';
                    if (($day_counter + 1) != $days_in_month) {
                        $calendar.= '<tr>';
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
                $calendar.= '<td class="next_month"></td>';
                for ($x = 2; $x <= (8 - $days_in_this_week); $x++) {
                    $calendar.= '<td class="next_month"></td>';
                }
            }

            /* final row */
            $calendar.= '</tr></tbody></table>';

            /* todo ende */

            /* closes "month" and "month_container" */
            $calendar.= '</div></div>';
        }

        /* all done, return result */
        return $calendar;
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
