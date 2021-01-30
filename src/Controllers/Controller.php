<?php

namespace App\Controllers;

use App\Traits\Response;

class Controller
{
    use Response;

    public function sendResponse($data)
    {
        $this->response($data);
    }

    public function sendError($message, $status)
    {
        $this->error($message, $status);
    }
}