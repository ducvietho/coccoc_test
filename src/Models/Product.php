<?php

namespace App\Models;

class Product
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllByUser($userId) {
        $statement = 'Select * from products where user_id = :user_id';
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'user_id' => $userId
            ]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}