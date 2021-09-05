<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ajaxError($message = "Сервер вернул ошибку!")
    {
        return response()->json([
            'status'    => 'error',
            'message'   => $message
        ]);
    }

    public function ajaxErrorForm($fields = [])
    {
        return response()->json(array_merge(['status' => 'error_form'], $fields));
    }

    public function ajaxErrorFieldsForm($validation = null)
    {
        return response()->json(['message' => 'The given data was invalid.', 'errors' => $validation->errors()], 422);
    }

    public function ajaxSuccess($data = [])
    {
        $result = ['status' => 'success'];

        if (is_string($data)) {
            $result['message'] = $data;
        } else {
            $result['data'] = $data;
        }

        return response()->json($result);
    }
}
