<?php
    /**
     * Created by PhpStorm.
     * User: kking
     * Date: 12/10/18
     * Time: 4:15 PM
     */

    include_once '../db.php';
    include_once '../models/employee.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();
    $emplyee = new employee($cnct);


    if (!empty($_POST) && !empty($_FILES['certification'])){
        $imgData = addslashes(file_get_contents($_FILES['certification']['tmp_name']));
        echo $emplyee->create($_POST,$_FILES['certification']);
    }