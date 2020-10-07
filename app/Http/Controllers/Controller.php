<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data = null, $message = 'success', int $status = 200)
    {
        return $this->response($data, $message, 0, $status);
    }

    public function failure($message = 'failure', int $status = 200)
    {
        return $this->response(null, $message, -1, $status);
    }

    /**
     * Custom default response
     *
     * @param null $data
     * @param null $message
     * @param int $code
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response($data = null, $message = null, int $code = -1, int $status = 200, array $headers = [])
    {
        return new JsonResponse([
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ], $status, $headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
