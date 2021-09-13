<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ajaxError($message = "Сервер вернул ошибку!", $status = 200)
    {
        return response()->json([
            'status'    => 'error',
            'message'   => $message
        ], $status);
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

    public function nextByRole($prefix)
    {
        if (!User::hasRole($prefix)) {
            return abort(403);
        }
    }
    
    public function nextByRoleAjax($prefix)
    {
        if (!User::hasRole($prefix)) {
            return $this->ajaxError('Доступ ограничен!', 403);
        }
    }
}
