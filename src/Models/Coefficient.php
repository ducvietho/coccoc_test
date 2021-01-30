<?php

namespace App\Models;

class Coefficient
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll() {
        $statement = 'Select * from coefficients';
        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($key) {
        $statement = "Select * from coefficients where name = ?";
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
            update coefficients
            set 
                value = :value
            where name = :name;
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
            insert into coefficients
                (name, value)
            value
                (:name, :value)
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