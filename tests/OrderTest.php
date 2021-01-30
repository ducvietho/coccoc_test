<?php

namespace Tests;

use App\Database\DatabaseConnect;
use App\Models\Coefficient;
use App\Models\Fee;
use App\Services\OrderService;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testCalculateGrossOrder()
    {
        $db = $this->getConnection();
        $orderService = new OrderService();
        $grossPrice = $orderService->calculateGrossPrice($db, 1);
        $this->assertEquals($grossPrice, 36013.4);
    }

    public function testUpdateCoefficient()
    {
        $input = [
            'name' => 'weight',
            'value' => 12
        ];
        $db = $this->getConnection();
        $coefficient = new Coefficient($db);
        $coefficient->update($input);
        $coefficientByKey = $coefficient->find('weight');
        $this->assertEquals($coefficientByKey[0]['value'], 12);
    }

    public function testInsertCoefficient()
    {
        $input = [
            'name' => 'other',
            'value' => 12
        ];
        $db = $this->getConnection();
        $coefficient = new Coefficient($db);
        $coefficient->insert($input);
        $coefficientByKey = $coefficient->find('other');
        $this->assertEquals($coefficientByKey[0]['name'], 'other');
        $this->assertEquals($coefficientByKey[0]['value'], 12);
    }

    public function testInsertFee()
    {
        $input = [
            'type' => 'other',
            'fee' => 12
        ];
        $db = $this->getConnection();
        $fee = new Fee($db);
        $fee->insert($input);
        $feeByType = $fee->find('other');
        $this->assertEquals($feeByType[0]['type'], 'other');
        $this->assertEquals($feeByType[0]['fee'], 12);
    }

    public function testUpdateFee()
    {
        $input = [
            'type' => 'other',
            'fee' => 12
        ];
        $db = $this->getConnection();
        $fee = new Fee($db);
        $fee->update($input);
        $feeByType = $fee->find('other');
        $this->assertEquals($feeByType[0]['fee'], 12);
    }

    private function getConnection() {
        $databaseConnect = new DatabaseConnect();
        return $databaseConnect->getConnection();
    }

}