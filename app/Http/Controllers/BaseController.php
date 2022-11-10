<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller {

    public function responseJson($error = false, $msg = "Success", $errors = null, $payload = null, $status = 200)
    {
        return response()->json([
            'error' => $error,
            'msg' => $msg,
            'errors' => $errors,
            'payload' => $payload
        ], $status);
    }
}