<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

class DefaultController extends BaseController
{
    private $_code = 500;
    private $_response = [];

    public function defaultMessage(Request $request)
    {
        $this->_response['success'] = true;
        $this->_response['message'] = "RestAPI v1";
        
        $this->_code = 200;

        return response()->json($this->_response, $this->_code);
    }
}