<?php

namespace App\Controllers;

use App\Services\OrderService;
use App\Utils\Consts;

class OrderController extends Controller
{
    private $orderService;
    private $db;

    public function __construct(OrderService $orderService, $db)
    {
        $this->orderService = $orderService;
        $this->db = $db;
    }

    public function index($uri) {
        $params = $_POST;
        if (count($uri) > 3) {
            exit($this->error('Not Found', 404));
        }
        switch ($uri[1]) {
            case Consts::CART_URI:
                $userId = (int) $uri[2];
                if (!$userId) {
                    exit($this->error('Not Found', 404));
                }
                $this->calculateGrossPrice($userId);
                break;
            case Consts::COEFFICIENT_URI:
                $params['name'] = $uri[2];
                $this->editCoefficient($params);
                break;
            case Consts::FEE_URI:
                $params['type'] = $uri[2];
                $this->editFee($params);
                break;
        }

    }

    public function calculateGrossPrice($userId)
    {
        $data = $this->orderService->calculateGrossPrice($this->db, $userId);
        return $this->sendResponse($data);
    }

    public function editCoefficient($params) {
        $data = $this->orderService->editCoefficient($this->db, $params);
        return $this->sendResponse($data);
    }

    public function editFee($params) {
        $data = $this->orderService->editFee($this->db, $params);
        return $this->sendResponse($data);
    }

}