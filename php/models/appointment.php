<?php
/**
 * Created by PhpStorm.
 * User: kking
 * Date: 12/9/18
 * Time: 11:04 AM
 */

class appointment
{
    private $connection;
    private $table_name = "appointment";

    public $id;
    public $user;
    public $date;
    public $time;
    public $visit_reason;

    public function __construct($connection){
        $this->connection = $connection;
    }

    //C
    public function create($app_data){
        $sql = "INSERT INTO " . $this->table_name . " (member, date, time, visit_reason) VALUES (?,?,?,?)";

        $vars = [];
        foreach ($app_data as $val) {
            array_push($vars, $val);
        }
        try{
            $this->connection->prepare($sql)->execute($vars);
            return json_encode($this->getAppointmentByUserID($app_data['id']));
        } catch(PDOException $err) {
            echo $err;
            http_response_code(400);
            switch ($err->getCode()) {
                default:
                    return 'failed to create';
            }
        }
    }

    public function getAppointmentById($id){
      $stmt = $this->connection->query('select * from ' . $this->table_name . ' WHERE id =  "'. $id . '"');
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $data[0];
    }

    public function getAppointmentByUserID($id){
        $stmt = $this->connection->query('select * from ' . $this->table_name . ' WHERE member =  "'. $id . '"');
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getAppointmentsByDate($date) {
        try{
            $stmt = $this->connection->query('select * from ' . $this->table_name . ' WHERE date =  "'. $date . '"');
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }catch(PDOException $err) {
            echo $err;
        }
    }
    //R
    public function read(){
        $stmt = $this->connection->query('select * from ' . $this->table_name);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    //U
    public function update($data){
        $sql = "UPDATE " . $this->table_name . " SET ";
        foreach (array_keys($data) as $index => $key) {
            if ($key != 'id') {
                switch (gettype($data[$key])) {
                    case 'integer':
                        $sql .= $key . " =  " . $data[$key] . " ";
                        break;
                    case 'double':
                        $sql .= $key . " =  " . $data[$key] . " ";
                        break;
                    default:
                        $sql .= $key . " =  \"" . $data[$key] . "\" ";
                        break;
                }
                if ($index !== sizeof(array_keys($data)) - 1){
                   $sql .= " , ";
                }
            }
        }
        $sql = $sql . " WHERE  id = " . $data['id'];
        try {
            $this->connection->prepare($sql)->execute();
            return json_encode($this->getAppointmentById($data['id']));
        } catch(PDOException $err) {
            echo $err->getMessage();
            http_response_code(400);
            switch ($err->getCode()) {
                default:
                    return 'failed to update';
            }
        }
    }
    //D
    public function removeService($id) {
        $stmt = $this->connection->query(`DELETE ${$this->table_name} WHERE id = '${$id}'`);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}