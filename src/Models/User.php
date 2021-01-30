<?php

namespace App\Models;

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function find($userId) {
        $statement = 'Select * from users where id = :user_id';
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