<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{

    public function responseSuccess($success_code, $data = []): \Illuminate\Http\JsonResponse
    {
        return $this->respond(config('api-code.status.success'), $success_code, $data);
    }

    public function responseError($error_code, $message, $data = []): \Illuminate\Http\JsonResponse
    {
        return $this->respond(config('api-code.status.error'), $error_code, $data, $message);
    }

    public function respond($status, $error_code = 0, $data = [], $message = ''): \Illuminate\Http\JsonResponse
    {
        $response = [
            'status' => $status,
            'code' => (int)$error_code,
            'data' => $data
        ];

        if(!empty($message)) $response['message'] = $message;
        return Response::json($response);
    }

    public function responseFailProcess(): \Illuminate\Http\JsonResponse
    {
        return $this->respond(config('api-code.status.error'), config('api-code.error_code.fail_process'), []);
    }

    public function responseDataNotFound(): \Illuminate\Http\JsonResponse
    {
        return $this->respond(config('api-code.status.error'), config('api-code.error_code.data_not_found'), []);
    }

    public function responseParametersInvalid(): \Illuminate\Http\JsonResponse
    {
        return $this->respond(config('api-code.status.error'), config('api-code.error_code.parameters_invalid'), []);
    }
}
