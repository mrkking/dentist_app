<?php
/**
 * Created by PhpStorm.
 * User: kking
 * Date: 12/10/18
 * Time: 4:13 PM
 */

    include_once '../db.php';
    include_once '../models/employee.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();
    $emp = new employee($cnct);

    if (empty($_GET)) {
        return $emp->read();
    }