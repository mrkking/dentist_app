<?php
/**
 * Created by PhpStorm.
 * User: takisha
 * Date: 12/10/18
 * Time: 2:17 PM
 */

class service
{
    private $connection;
    private $table_name = "service";

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    //C
    public function create($user_data)
    {
        $sql = "INSERT INTO " . $this->table_name . " (name, duration, description) VALUES (?,?,?,?,?)";

        $vars = [];
        foreach ($user_data as $val) {
            array_push($vars, $val);
        }
        try {
            $this->connection->prepare($sql)->execute($vars);
            return $this->read();
        } catch (PDOException $err) {
            http_response_code(400);
            switch ($err->getCode()) {
                case 23000:
                    return 'email already exists';
                default:
                    return 'failed to create';
            }

        }
    }

    public function read() {
        $stmt = $this->connection->query('select * from ' . $this->table_name);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function update($data){
        $sql = "UPDATE " . $this->table_name . " SET ";
        foreach (array_keys($data) as $index => $key) {
            if ($key != 'id') {
                switch (gettype($data[$key])) {
                    case 'integer':
                        $sql = $sql . $key . " =  " . $data[$key] . " ";
                        break;
                    case 'double':
                        $sql = $sql . $key . " =  " . $data[$key] . " ";
                        break;
                    default:
                        $sql = $sql . $key . " =  \"" . $data[$key] . "\" ";
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
            return json_encode($this->getUserByID($data['id'])[0]);
        } catch(PDOException $err) {
            echo $err->getMessage();
            http_response_code(400);
            switch ($err->getCode()) {
                default:
                    return 'failed to update';
            }
        }
    }

    public function removeService($id) {
        $stmt = $this->connection->query(`DELETE ${$this->table_name} WHERE id = '${$id}'`);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}