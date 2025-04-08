<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

trait Responds
{
    /**
     * Success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function success($data = null, $message = 'Success', $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Error response
     *
     * @param string $message
     * @param int $status
     * @param mixed $errors
     * @return JsonResponse
     */
    public function error($message = 'Error', $errors = null, $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $this->logError($message, $status, $errors);
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    /**
     * Log the error details to the log file.
     *
     * @param  string $message
     * @param  int $status
     * @param  mixed $errors
     * @return void
     */
    protected function logError(string $message, int $status, $errors = null): void
    {
        $logMessage = [
            'message' => $message,
            'status' => $status,
            'errors' => $errors,
            'timestamp' => now()->toDateTimeString(),
        ];

        Log::channel('daily')->error('Error Response', $logMessage);
    }

    /**
     * Not found response
     *
     * @param string $message
     * @return JsonResponse
     */
    public function notFound($message = 'Not Found'): JsonResponse
    {
        return $this->error($message, null, Response::HTTP_NOT_FOUND);
    }

    /**
     * Internal server error response
     *
     * @param string $message
     * @return JsonResponse
     */
    public function internalServerError($message = 'Internal Server Error'): JsonResponse
    {
        return $this->error($message, null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
