<?php

namespace App\Models;

class Cart
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllByUser($userId) {
        $statement = 'Select 
                        carts.id, carts.quantity, products.name, products.price, products.weight, products.width,
                        products.height, products.depth, products.fee_type, fees.fee
                      from 
                        carts
                      inner join products on products.id = carts.product_id
                      left join fees on fees.type = products.fee_type 
                      where user_id = :user_id and is_pay = 0';
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