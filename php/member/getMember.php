<?php
/**
 * Created by PhpStorm.
 * User: kking
 * Date: 12/9/18
 * Time: 3:48 PM
 */

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, OPTIONS, POST");

    include_once '../db.php';
    include_once '../models/member.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();
    $user = new member($cnct);

    if(!empty($_GET['id'])) {
        $data = $user->getMemberByID($_GET['id']);
        echo json_encode($data[0]);
    }

    if (!empty($_GET['email']) && !empty($_GET['password'])){
        $data = $user->getMemberByCredentials($_GET['email'], $_GET['password']);
        echo json_encode($data[0]);
    }