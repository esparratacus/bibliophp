<?php
/**
 * Created by PhpStorm.
 * User: guerrerojosedario
 * Date: 2018/06/01
 * Time: 4:57 PM
 */
include_once ROOT_PATH . '/Model/Mapper/RentalMapper.php';
include_once ROOT_PATH . '/Model/Mapper/ReportMapper.php';
include_once ROOT_PATH . '/Model/Mapper/UserMapper.php';

date_default_timezone_set('America/Bogota');

class ReportReminder
{
    private $reportMapper;
    private $rentalMapper;
    private $userMapper;

    public function __construct($con)
    {
        $this->reportMapper = new ReportMapper($con);
        $this->rentalMapper = new RentalMapper($con);
        $this->userMapper = new UserMapper($con);
       
        if(!isset($_SESSION['report_reminder']))
            $_SESSION['report_reminder'] = ['admin' => []];

    }

    private function createInterval($interval_string)
    {
        $interval_spec = "";
        $interval = explode(" ", $interval_string);
        switch ($interval[1]){
            case "MONTH" : $interval_spec = "P$interval[0]M"; break;
            case "DAY" : $interval_spec = "P$interval[0]D"; break;
            case "HOUR" : $interval_spec = "PT$interval[0]H"; break;
            case "MINUTES" : $interval_spec = "PT$interval[0]M"; break;
        }
        return new DateInterval($interval_spec);
    }

    public function remind() {

        $rentals = $this->rentalMapper->findApproved();
        foreach($rentals as $rental){
            $user = $this->userMapper->findById($rental->user_id);
            $report = $this->reportMapper->findLastReport($user->id, $rental->equipment_id);
            $date_compare = $report ? $report->date : $rental->creation_date;
            $date =  new DateTime($date_compare);
            $date->add($this->createInterval($rental->report_interval));

            $this->sendMailUser($user, $rental, $rental->equipment->load(), $date);

            $cur_date = new DateTime();
            if($cur_date > $date){
                $this->sendMailAdmin($user, $rental, $rental->equipment->load(), $date);
            }
        }
    }


    private function sendMailUser($user, $rental, $equipment, $dateend){
        $send_mail = false;
        $date = $dateend->format("Y-m-d H:i:s");
        if(!isset($_SESSION['report_reminder'][$user->id]))
            $_SESSION['report_reminder'][$user->id] = [];
        if(!isset($_SESSION['report_reminder'][$user->id][$rental->id])){
            $_SESSION['report_reminder'][$user->id][$rental->id] = $date;
            $send_mail = true;
        }else{
            $session_date = new DateTime($_SESSION['report_reminder'][$user->id][$rental->id]);
            //var_dump($session_date);
            //var_dump($dateend);
            if($session_date < $dateend){
                $_SESSION['report_reminder'][$user->id][$rental->id] = $date;
                $send_mail = true;
            }
        }
        
        if($send_mail){
            $email = $user->email;
            $subject = "Recordatorio presentarse evaluación de equipo";
            $message = "Le recordamos que presentarse antes de $date para evaluar el estado del equipo prestado. 
                Equipo : ". $equipment->name . " " . $equipment->maker . " " . $equipment->serial_number;
            //var_dump($email);
            //var_dump($subject);
            //var_dump($message);
            $message = wordwrap($message, 70, "\r\n");
            mail($email, $subject, $message);
        }
    }

    private function sendMailAdmin($user, $rental, $equipment, $dateend){
        $send_mail = false;
        $date = $dateend->format("Y-m-d H:i:s");

        if(!isset($_SESSION['report_reminder']['admin'][$rental->id])){
            $_SESSION['report_reminder']['admin'][$rental->id] = $date;
            $send_mail = true;
        }else{
            $session_date = new DateTime($_SESSION['report_reminder']['admin'][$rental->id]);
            if($session_date < $dateend){
                $_SESSION['report_reminder']['admin'][$rental->id] = $date;
                $send_mail = true;
            }
        }
        if($send_mail){
            $email = $this->userMapper->findById(1)->email;
            $subject = "Recordatorio usuario no se presentó evaluación de equipo";
            $message = "El usuario ".$user->username." no se presento antes de $date para evaluar el estado del equipo prestado. 
                Equipo : ". $equipment->name . " " . $equipment->maker . " " . $equipment->serial_number;
            //var_dump($email);
            //var_dump($subject);
            //var_dump($message);
            $message = wordwrap($message, 70, "\r\n");
            mail($email, $subject, $message);
        }
    }
}