<?php
/**
 * Created by PhpStorm.
 * User: kking
 * Date: 12/10/18
 * Time: 4:16 PM
 */

    include_once '../db.php';
    include_once '../models/member.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();
    $user = new member($cnct);

    if(!empty($_POST['id'])){
        echo $user->removeMember($_POST['id']);
    }
