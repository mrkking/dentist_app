<?php
/**
 * Created by PhpStorm.
 * User: takisha
 * Date: 12/9/18
 * Time: 7:54 PM
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include_once '../db.php';
    include_once '../models/appointment.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();
    $appointment = new appointment($cnct);

    if(!empty($_POST)){
        echo $appointment->update($_POST);
    }