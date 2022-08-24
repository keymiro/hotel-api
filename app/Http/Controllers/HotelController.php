<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $hotels = Hotel::all();
       return response()->json(['hoteles'=>$hotels]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = $this->validation($request);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $hotel = Hotel::create($request->all());

        return response()->json(['message'=>'register created','hotel'=>$hotel]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $hotel = Hotel::find($id);

      if (empty($hotel)) {
        return response()->json(['message'=>'register not found']);
      }
      return response()->json(['hotel'=>$hotel]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $hotel = Hotel::find($id);

        if (empty($hotel)) {
            return response()->json(['message'=>'register not found']);
        }

        $hotel->update($request->all());

        return response()->json(['message'=>'register updated','hotel'=>$hotel]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Hotel::destroy($id);

        return response()->json(['message'=>'register deleted']);
    }

    public function validation($request){

        $validator = Validator::make($request->all(),
        [
            'name'            => 'required|string|max:255',
            'city'            => 'required|string|max:255',
            'address'         => 'required|string|max:255',
            'nit'             => [
                                  'required',
                                  'string',
                                  'max:255',
                                  Rule::unique('hotels')->ignore($request->route('id'))
                                 ],
            'max_rooms'       => 'required|string|max:255',
            'user_created_id' => 'required|exists:users,id|max:255',
        ]);

        return $validator;
    }

}
