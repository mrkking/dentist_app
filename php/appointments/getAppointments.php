<?php
/**
 * Created by PhpStorm.
 * User: kking
 * Date: 12/9/18
 * Time: 7:21 PM
 */

    include_once '../db.php';
    include_once '../models/appointment.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();
    $app = new appointment($cnct);

    if(!empty($_GET['user'])) {
        $data = $app->getAppointmentByUserID($_GET['user']);
        echo json_encode($data);
    }

    if(!empty($_GET['id'])) {
        $data = $app->getAppointmentByID($_GET['id']);
        echo json_encode($data);
    }

    if(empty($_GET)){
        $data = $app->read();
        echo json_encode($data);
    }

    if(!empty($_GET['date'])) {
        $data = $app->getAppointmentsByDate($_GET['date']);
        echo json_encode($data);
    }



