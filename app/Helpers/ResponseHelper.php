<?php

namespace App\Helpers;

final class ResponseHelper
{
    private const ACTION_REDIRECT = 'redirect';


    private ?array $response;


    public static function create(): self
    {
        return new self();
    }


    public function withMessage(string $message, string $type = 'info'): self
    {
        $this->response['message'] = $message;
        $this->response['type'] = $type;

        return $this;
    }


    public function withRedirect(string $to): self
    {
        $this->response['action'] = self::ACTION_REDIRECT;
        $this->response['to'] = $to;

        return $this;
    }


    public function send(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->response);
    }
}
