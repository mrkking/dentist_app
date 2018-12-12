<?php
/**
 * Created by PhpStorm.
 * User: kking
 * Date: 12/10/18
 * Time: 4:15 PM
 */

    include_once '../db.php';
    include_once '../models/appointment.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();
    $appointment = new appointment($cnct);

    if(!empty($_POST['id'])){
        echo $appointment->update($_POST['id']);
    }