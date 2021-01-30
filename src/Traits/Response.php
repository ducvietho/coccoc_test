<?php

namespace App\Traits;

use App\Utils\Consts;

trait Response
{
    public function response($data)
    {
        header('Content-Type: application/json');
        header('X-PHP-Response-Code: '.Consts::HTTP_STATUS_OK, true, Consts::HTTP_STATUS_OK);
        $response = [
            'message' => 'success',
            'data' => $data
        ];
        echo json_encode($response);
    }

    public function error($message, $status)
    {
        header('Content-Type: application/json');
        header('X-PHP-Response-Code: '.$status, true, $status);
        $response = [
            'message' => $message
        ];
        echo json_encode($response);
    }
}