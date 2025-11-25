<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected const STATUS_SUCCESS = 'success';
    protected const STATUS_ERROR = 'error';

    protected function sendRedirect(string $to = '/') {
        return response()->json([
            'action' => 'redirect',
            'to' => $to,
        ]);
    }


    protected function sendMessage(string $message, string $type = self::STATUS_SUCCESS) {
        return response()->json([
            'message' => $message,
            'type' => $type,
        ]);
    }
}
