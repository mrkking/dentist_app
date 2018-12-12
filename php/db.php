<?php
/**
 * Created by PhpStorm.
 * User: takisha
 * Date: 12/9/18
 * Time: 10:20 AM
 */


class db {
    private $host = "localhost";
    private $username = "root";
    private $password = "root";
    private $dbname = "dentist_new";

    public $connection = null;

    //get db connection
    public function getConnection(){
        $this->connection = null;

        try{
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->exec("set names utf8");
        }catch (PDOException $exception){
            echo "Error: ".$exception->getMessage();
        }

        return $this->connection;
    }

    public function read($table) {
        $stmt = $this->connection->query('select * from ' . $table);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function update($table, $data) {
        $sql = "UPDATE " . $table . " SET ";
        foreach (array_keys($data) as $index => $key) {
            if($key == 'id'){
                continue;
            }

            switch (gettype($data[$key])) {
                case 'integer':
                    $sql = $sql . $key . " =  " . $data[$key] . " ";
                    break;
                case 'double':
                    $sql = $sql . $key . " =  " . $data[$key] . " ";
                    break;
                case 'string':
                    $sql = $sql . $key . " =  \"" . $data[$key] . "\" ";
                    break;
                default:
                    break;
            }
            if ($index !== sizeof(array_keys($data)) - 2){
                $sql .= " , ";
            }
        }
        $sql = $sql . " WHERE  id = " . $data['id'];
        try {
            $connection = $this->getConnection();
            $connection->query($sql);
            return 'success';
        } catch(PDOException $err) {
            echo $err->getMessage();
            http_response_code(400);
            switch ($err->getCode()) {
                default:
                    return 'failed to update';
            }
        }
    }

    public function remove($table, $id) {
        try {
            $this->connection->exec("DELETE FROM " . $table ." WHERE id = \"" . $id . "\"");
            return 'record deleted';
        }catch(PDOException $err){
            return $err->getMessage();
        }
    }
}