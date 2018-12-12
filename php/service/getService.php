<?php
/**
 * Created by PhpStorm.
 * User: takisha
 * Date: 12/10/18
 * Time: 4:17 PM
 */

include_once '../db.php';

    $dbcnct =  new db();
    $cnct = $dbcnct ->getConnection();

    if (empty($_GET)) {
        $data = $cnct->prepare('select * from service');
        $data->execute();
        $s = $data->fetchAll(PDO::FETCH_ASSOC);
        print_r(json_encode($s));
    }