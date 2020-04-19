<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\BuildingHeaderRequest;
use App\Models\Building\Header;

use EloquentBuilder;

class BuildingController extends BaseController
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
        $building = Header::get();

        $this->_response['success'] = true;
        $this->_response['data'] = $building;
        $this->_code = 200;

        return response($this->_response, $this->_code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BuildingHeaderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuildingHeaderRequest $request)
    {
        $validatedInput = $request->validated();

        $status = Header::create($validatedInput);

        if ($status) {
            $this->_response['success'] = true;
            $this->_response['data'] = $status;
            $this->_code = 201;
        } else {
            $this->_response['success'] = false;
            $this->_response['desc'] = "Failed storing to database";
        }

        return response($this->_response, $this->_code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Building\Header  $header
     * @return \Illuminate\Http\Response
     */
    public function show(Header $header)
    {
        $header->load('buildingChilds');

        $this->_response['success'] = true;
        $this->_response['data'] = $header;
        $this->_code = 200;

        return response($this->_response, $this->_code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BuildingHeaderRequest $request
     * @param  \App\Models\Building\Header  $header
     * @return \Illuminate\Http\Response
     */
    public function update(Header $header, BuildingHeaderRequest $request)
    {
        $validatedInput = $request->validated();

        $status = $header->update($validatedInput);

        if ($status) {
            $this->_response['success'] = true;
            $this->_response['data'] = $status;
            $this->_code = 200;
        } else {
            $this->_response['success'] = false;
            $this->_response['desc'] = "Failed save your changes to database";
        }

        return response($this->_response, $this->_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Building\Header  $header
     * @return \Illuminate\Http\Response
     */
    public function destroy(Header $header)
    {
        if ($header->delete()) {
            $this->_response['success'] = true;
            $this->_response['data'] = $header;
            $this->_code = 410;
        }

        return response()->json($this->_response, $this->_code);
    }
}
