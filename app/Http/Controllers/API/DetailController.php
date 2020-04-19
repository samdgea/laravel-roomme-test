<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\BuildingDetailRequest;
use App\Models\Building\Header;
use App\Models\Building\Detail;

use EloquentBuilder;

class DetailController extends BaseController
{
    private $_code = 500;
    private $_response = [];

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BuildingDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Header $header, BuildingDetailRequest $request)
    {
        $validatedInput = $request->validated();
        $validatedInput['building_header_id'] = $header->id;

        $status = Detail::create($validatedInput);

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
     * @param  \App\Models\Building\Detail  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Header $header, Detail $id)
    {
        $data = Detail::where(['id' => $id->id, 'building_header_id' => $header->id])->first();
        
        $this->_response['success'] = true;
        $this->_response['data'] = $data;
        $this->_code = 200;

        return response($this->_response, $this->_code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BuildingDetailRequest $request
     * @param  \App\Models\Building\Header  $header
     * @param  \App\Models\Building\Detail  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Header $header, Detail $id, BuildingDetailRequest $request)
    {
        $validatedInput = $request->validated();

        $data = Detail::where(['id' => $id->id, 'building_header_id' => $header->id])->update($validatedInput);

        if ($data) {
            $this->_response['success'] = true;
            $this->_response['data'] = $data;
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
     * @param  \App\Models\Building\Detail  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Header $header, Detail $id)
    {
        $data = Detail::where(['id' => $id->id, 'building_header_id' => $header->id])->first();

        if ($data->delete()) {
            $this->_response['success'] = true;
            $this->_response['data'] = $data;
            $this->_code = 410;
        } else {
            $this->_response['success'] = false;
            $this->_response['desc'] = "Invalid ID";
            $this->_code = 404;
        }

        return response()->json($this->_response, $this->_code);
    }
}
