<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function  sendResponse($result, $message)
    {
        $reponse = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($reponse, 201);
    }

    public function  sendError($error, $erorMessage = [], $code = 404)
    {
        $reponse = [
            'success' => false,
            'message' => $error
        ];

        if (!empty($erorMessage)) {
            $reponse['data'] = $erorMessage;
        }

        return response()->json($reponse, $code);
    }
}
