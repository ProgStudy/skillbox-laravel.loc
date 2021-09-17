<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * ajaxError function
     *
     * @param string $message
     * @param integer $status
     * @return \Illuminate\Http\Response
     */
    public function ajaxError($message = "Сервер вернул ошибку!", $status = 200)
    {
        return response()->json([
            'status'    => 'error',
            'message'   => $message
        ], $status);
    }

    /**
     * ajaxErrorForm function
     *
     * @param array $fields
     * @return \Illuminate\Http\Response
     */
    public function ajaxErrorForm($fields = [])
    {
        return response()->json(array_merge(['status' => 'error_form'], $fields));
    }

    /**
     * ajaxErrorFieldsForm function
     *
     * @param [type] $validation
     * @return \Illuminate\Http\Response
     */
    public function ajaxErrorFieldsForm($validation = null)
    {
        return response()->json(['message' => 'The given data was invalid.', 'errors' => $validation->errors()], 422);
    }

    /**
     * ajaxSuccess function
     *
     * @param array $data
     * @return \Illuminate\Http\Response
     */
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

    /**
     * nextByRole function
     *
     * @param [type] $prefix
     * @return \Illuminate\Http\Response
     */
    public function nextByRole($prefix)
    {
        if (!User::hasRole($prefix)) {
            return abort(403);
        }
    }
    
    /**
     * nextByRoleAjax function
     *
     * @param [type] $prefix
     * @return \Illuminate\Http\Response
     */
    public function nextByRoleAjax($prefix)
    {
        if (!User::hasRole($prefix)) {
            return $this->ajaxError('Доступ ограничен!', 403);
        }
    }
}
