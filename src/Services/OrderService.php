<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coefficient;
use App\Models\Fee;
use App\Models\User;
use App\Traits\Response;

class OrderService
{
    use Response;
    public function calculateGrossPrice($db, $userId)
    {
        $userTable = new User($db);
        $user = $userTable->find($userId);
        if (!count($user)) {
            exit($this->error('User not found', 404));
        }
        $coefficient = new Coefficient($db);
        $coefficients = $coefficient->getAll();
        $weightCoefficient = $this->getCoefficient('weight', $coefficients);
        $dimensionCoefficient = $this->getCoefficient('dimension', $coefficients);
        $cart = new Cart($db);
        $carts = $cart->getAllByUser($userId);
        $grossPrice = 0;
        foreach ($carts as $item) {
            $feeProductType = $item['fee'] ? $item['fee'] : 0;
            $weightFee = $weightCoefficient * $item['weight'];
            $dimensionFee = $dimensionCoefficient * $item['width'] * $item['height'] * $item['depth'];
            $fee = max($feeProductType, $weightFee, $dimensionFee);
            $grossPrice += $item['quantity'] * ($item['price'] + $fee);
        }
        return $grossPrice;
    }

    public function editCoefficient($db, $params) {
        if (empty($params['value'])) {
            exit($this->error('value is required', 422));
        }
        $value = (int) $params['value'];
        if ($value <= 0) {
            exit($this->error('value invalid', 400));
        }
        $coefficientModel = new Coefficient($db);
        $coefficient = $coefficientModel->find($params['name']);
        if (!count($coefficient)) {
            exit($this->error('Coefficient not found', 400));
        }
        $input = [
            'name' => $params['name'],
            'value' => $params['value']
        ];
        $coefficientModel->update($input);
        $coefficient = $coefficientModel->find($params['name']);

        return $coefficient[0];
    }

    public function editFee($db, $params) {
        if (empty($params['fee'])) {
            exit($this->error('fee is required', 422));
        }
        $fee = (int) $params['fee'];
        if ($fee <= 0) {
            exit($this->error('fee invalid', 400));
        }
        $feeModel = new Fee($db);
        $fee = $feeModel->find($params['type']);
        if (!count($fee)) {
            exit($this->error('Fee not found', 400));
        }
        $input = [
            'type' => $params['type'],
            'fee' => $params['fee']
        ];
        $feeModel->update($input);
        $fee = $feeModel->find($params['type']);

        return $fee[0];

    }
    private function getCoefficient($key, $coefficients) {
        $index = array_search($key, array_column($coefficients, 'name'));
        return $coefficients[$index]['value'];
    }
}