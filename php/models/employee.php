<?php
/**
 * Created by PhpStorm.
 * User: kking
 * Date: 12/10/18
 * Time: 2:17 PM
 */
    include_once '../db.php';

    class employee
    {
        private $connection;
        private $table_name = "employee";
        private $db = null;

        public function __construct($connection)
        {
            $this->connection = $connection;
            $this->db = new db();
        }

        //C
        public function create($data, $cert) {
            $sql = "INSERT INTO " . $this->table_name . " (certification, expiration, member_id) 
            VALUES (" .
                "\"".$cert['tmp_name'] . "\"," .
                "\"".$data['expiration'] . "\"," .
                "\"".$data['member_id'] . "\"" .
            ")";
            try {
                $this->connection->exec($sql);
                return 'empl0yee created';
            } catch (PDOException $err) {
                http_response_code(400);
                switch ($err->getCode()) {
                    case '23000':
                        return 'employee already exists';
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

        public function getEmployeeByID($id){
            $stmt = $this->connection->query('select * from ' . $this->table_name . ' WHERE id =  "'. $id . '"');
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }

        public function update($data){
            return $this->db->update($this->table_name, $data);
        }

        public function removeEmployee($id) {
            try {
                $this->connection->exec("DELETE FROM " . $this->table_name ." WHERE id = \"" . $id . "\"");
                return 'member deleted';
            }catch(PDOException $err){
                return $err->getMessage();
            }
        }
    }