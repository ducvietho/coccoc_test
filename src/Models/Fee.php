<?php

namespace App\Models;

class Fee
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll() {
        $statement = 'Select * from fees';
        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($key) {
        $statement = "Select * from fees where type = ?";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($key));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($input)
    {
        $statement = '
            update fees
            set
                fee = :fee
            where type = :type;
        ';

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute($input);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert($input)
    {
        $statement = '
            insert into fees
                (type, fee)
            value
                (:type, :fee)
        ';

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute($input);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}