<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dataSuccess($mes, $data = [],$code = 200)
    {
        return response()->json([
            'result'  => true,
            'message' => $mes,
            'data'    => $data,
            'code'  =>200

        ], $code);
    }

    public function dataError($mes, $data = [], $code = 200)
    {
        return response()->json([
            'result'  => false,
            'message' => $mes,
            'data'    => $data,
            'code'    => $code
        ], $code);
    }
}
