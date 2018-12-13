<?php
/**
 * Created by PhpStorm.
 * User: takisha
 * Date: 12/9/18
 * Time: 1:54 PM
 */

    include_once '../db.php';
    include_once '../models/member.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();
    $user = new member($cnct);


    if(file_get_contents( 'php://input' )) {
        echo $user->create(file_get_contents( 'php://input' ));
    } else {
        http_response_code(422);
        echo 'invalid parameters';
    }