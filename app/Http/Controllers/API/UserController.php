<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;


use EloquentBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $_code = 500;
    private $_response = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = EloquentBuilder::to(
            User::class, 
            $request->filter
        );
        
        $this->_response['success'] = true;
        $this->_response['data'] = $users->get();
        $this->_code = 200;

        return response()->json($this->_response, $this->_code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, UserRequest $request)
    {
        $validatedData = $request->validated();

        $user->first_name = $validatedData['first_name'];
        $user->last_name = $validatedData['last_name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->is_active = $validatedData['is_active'];

        if ($user->save()) {
            $this->_response['success'] = true;
            $this->_response['data'] = $user;
            $this->_code = 201;
        }

        return response()->json($this->_response, $this->_code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->_response['success'] = true;
        $this->_response['data'] = $user;
        $this->_code = 200;

        return response()->json($this->_response, $this->_code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $validatedData = $request->validated();

        $user->first_name = $validatedData['first_name'];
        
        // Change email when key last_name present
        if (!empty($validatedData['last_name']))
            $user->last_name = $validatedData['last_name'];

        // Change email when key email present
        if (!empty($validatedData['email']))
            $user->email = $validatedData['email'];
        
        // Change password if key "password" present
        if (!empty($validatedData['password']))
            $user->password = Hash::make($validatedData['password']);
        
        if (!empty($validatedData['is_active']))
            $user->is_active = $validatedData['is_active'];

        if ($user->save()) {
            $this->_response['success'] = true;
            $this->_response['data'] = $user;
            $this->_code = 200;
        }

        return response()->json($this->_response, $this->_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            $this->_response['success'] = true;
            $this->_response['data'] = $user;
            $this->_code = 410;
        }

        return response()->json($this->_response, $this->_code);
    }
}
