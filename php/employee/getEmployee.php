<?php
/**
 * Created by PhpStorm.
 * User: takisha
 * Date: 12/10/18
 * Time: 4:13 PM
 */

    include_once '../db.php';
    include_once '../models/employee.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();
    $emp = new employee($cnct);

    if (empty($_GET)) {
        $data = $cnct->prepare('SELECT e.id, e.start_date, m.first_name, m.last_name, m.role, m.id as member FROM employee e join member m WHERE m.id = e.member_id');
        $data->execute();
        $s = $data->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($s));
    }