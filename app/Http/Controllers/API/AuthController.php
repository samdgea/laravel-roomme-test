<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use App\Models\User;

use Lcobucci\JWT\Parser;

class AuthController extends Controller
{
    private $_code = 500;
    private $_response = [];

    public function login(AuthRequest $request)
    {
        $validatedInput = $request->validated();

        $user = User::where('email', $validatedInput['email'])->first();

        if (!empty($user) && $user->is_active == true) {
            $accessToken = $user->createToken(config('app.name', 'Laravel'))->accessToken;

            $this->_response['success'] = true;
            $this->_response['data'] = $user;
            $this->_response['data']['accessToken'] = $accessToken;

            $this->_code = 200;
        } else {
            $this->_response['success'] = false;
            $this->_response['desc'] = "Invalid email, password combination, or inactive account";

            $this->_code = 404;
        }

        return response()->json($this->_response, $this->_code);
    }

    public function logout(Request $request) 
    {
        $token = (new Parser)->parse($request->bearerToken())->getHeader('jti');
        $currentToken = $request->user()->tokens->find($token);

        if (!empty($currentToken)) {
            $currentToken->revoke();
            
            $this->_response['success'] = true;
            $this->_response['desc'] = 'Logout successfully';
            $this->_code = 200;
        } else {
            $this->_response['success'] = true;
            $this->_response['desc'] = 'Invalid Token ID';
            $this->_code = 400;
        }

        return response()->json($this->_response, $this->_code);
    }
}
