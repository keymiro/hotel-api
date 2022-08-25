<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\TypeRoom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hotelWithRooms($id)
    {
        $hotelWithRooms = Room::where('hotel_id',$id)->get();
        $hotel = DB::table('hotels')
                        ->select('hotels.id','hotels.name','hotels.city','hotels.address','hotels.nit','hotels.max_rooms',
                        DB::raw('count(rooms.id) as has_total_rooms'))
                        ->join('rooms','rooms.hotel_id','=','hotels.id')
                        ->where('hotels.id',$id)
                        ->groupBy('hotels.id')
                        ->get();
                        
        return response()->json(
            [
                'hotel'=>$hotel,
                'hotelWithRooms'=>$hotelWithRooms,
            ]
        );
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

        $hotel=Hotel::find($request->hotel_id);
        $roomCount =Room::where('hotel_id',$request->hotel_id)->count('hotel_id');

        if ($hotel->max_rooms <= $roomCount) {
            return response()->json(['message'=>'maximum number of rooms exceeded']);
        }

        $room = Room::create($request->all());

        return response()->json(['message'=>'register updated','room'=>$room]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);

        $typeRoom = TypeRoom::find($room->type_room_id);

        $accommodations = json_decode($typeRoom->accommodations);

        if (empty($room)) {
            return response()->json(['message'=>'register not found']);
          }
          return response()->json(['room'=>$room,'accomodations'=>$accommodations]);
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

        $room = Room::find($id);

        if (empty($room)) {
            return response()->json(['message'=>'register not found']);
        }

        $room->update($request->all());

        return response()->json(['message'=>'register updated','room'=>$room]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Room::destroy($id);

        return response()->json(['message'=>'register deleted']);
    }

    public function validation($request){

        $validator = Validator::make($request->all(),
        [
            'number'             => [
                                  'required',
                                  'string',
                                  'max:255',
                                  Rule::unique('rooms')->ignore($request->route('id'))
                                 ],
            'amount'            => 'required|numeric|between:0,999.999',
            'type_room_id'      => 'required|exists:rooms,id|max:255',
            'hotel_id'          => 'required|exists:hotels,id|max:255',
            'user_created_id'   => 'required|exists:users,id|max:255',
        ]);

        return $validator;
    }

    public function assignRoomTypeAccommodations(Request $request,$id){

        $room = Room::find($id);
        $assing = $room->update(
            [
                'accommodations'=>$request->accommodations
            ]
        );

        if(!$assing){
            return response()->json(['message'=>'assignment failed']);
        }

        return response()->json(['message'=>'accommodation assigning correctly']);
    }
}
