<?php
namespace App\Traits;

trait ResponseTrait
{
    protected function respond($data, $statusCode = 200, $headers = [])
    {
        return response()->json($data, $statusCode, $headers);
    }

    protected function respondSuccess($data, $statusCode = 200, $headers = [])
    {
        return $this->respond([
            'success' => true,
            'data' => $data
        ], $statusCode, $headers);
    }

    protected function respondError($message, $status, $headers = [])
    {
        return $this->respond([
            'success' => false,
            'error' => [
                'message' => $message,
                'status' => $status,
            ]
        ], $status, $headers);
    }

    protected function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, 401);
    }

    protected function respondForbidden($message = 'Forbidden')
    {
        return $this->respondError($message, 403);
    }

    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError($message, 404);
    }

    protected function respondUnprocessableEntity($message = 'Unprocessable Entity')
    {
        return $this->respondError($message, 422);
    }

}



