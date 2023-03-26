<?php

namespace App\Http\Controllers\Api\V1\Helper;

use Illuminate\Http\Response;

trait ApiResponse
{

    public function coreResponse($message, $statusCode, $data = null, $isSuccess = true)
    {
        // Check the params
        if (!$message) return response()->json(['message' => 'Message is required'], 500);

        // Send the response
        if ($isSuccess) {
            return response()->json([
                'message' => $message,
                'error' => false,
                'code' => $statusCode,
                'data' => $data
            ], $statusCode);
        } else {
            return response()->json([
                'message' => $message,
                'error' => true,
                'code' => $statusCode,
                'data' => $data
            ], $statusCode);
        }
    }

    /**
     * Send any success response
     *
     * @param   string          $message
     * @param   array|object    $data
     * @param   integer         $statusCode
     */
    public function success($data = null, $message = "Operation Successful", $statusCode = 200)
    {
        return $this->coreResponse($message, $statusCode, $data);
    }

    /**
     * Send any error response
     *
     * @param   string          $message
     * @param   integer         $statusCode
     */
    public function error($message, $statusCode, $data = Null)
    {
        return $this->coreResponse($message, $statusCode, $data, false);
    }
    protected function errorResponse($message, $code)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => null
        ], $code);
    }

    protected function dataNotFound($message = 'No data found!', $code = Response::HTTP_NOT_FOUND)
    {
        return response()->json([
            'status' => 'false',
            'message' => $message,
            'data' => null
        ], $code);
    }
}
