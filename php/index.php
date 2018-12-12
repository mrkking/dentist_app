<?php
/**
 * Created by PhpStorm.
 * User: kking
 * Date: 10/29/18
 * Time: 10:59 PM
 */

    include_once './db.php';
    include_once './models/member.php';

    $dbcnct =  new db();

    $cnct = $dbcnct ->getConnection();

//    echo json_encode($cnct->query('select * from member'));
   

    if ($_POST['name']){
        echo 'test';
    }


//    $member = new member($cnct);

//    echo json_encode($member->read());


//    echo 'Hello world';

