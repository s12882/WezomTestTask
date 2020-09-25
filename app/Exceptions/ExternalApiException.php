<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ExternalApiException extends Exception
{
    /**
     * @param $request
     * @return JsonResponse
     */
    public function render($request)
    {
        return $this->handleAjax();
    }

    /**
     * Handle an ajax response.
     */
    private function handleAjax()
    {
        return response()->json([
            'status'   => false,
            'message' => $this->getMessage(),
        ], 200);
    }
}
