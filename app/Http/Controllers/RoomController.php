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
        // $hotelWithRooms = Room::where('hotel_id',$id)->get();
        $hotelWithRooms  = DB::table('rooms')
                                ->select('rooms.id','rooms.amount','rooms.number','rooms.accommodations','rooms.type_room_id','type_rooms.name as type_rooms', 'user_created_id')
                                ->join('type_rooms','type_rooms.id','=','rooms.type_room_id')
                                ->where('rooms.hotel_id',$id)
                                ->groupBy('rooms.id','type_rooms.name')
                                ->get();
        $hotel = DB::table('hotels')
                        ->select('hotels.id','hotels.name','hotels.city','hotels.address','hotels.nit','hotels.max_rooms',
                        DB::raw('count(rooms.id) as has_total_rooms'))
                        ->leftJoin('rooms','rooms.hotel_id','=','hotels.id')
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

        $repeatedRoom =Room::where('hotel_id',$request->hotel_id)->where('number',$request->number)->first();

        if ($repeatedRoom) {
            return response()->json(['message'=>'repeated room in the hotel']);
        }

        if ($hotel->max_rooms <= $roomCount) {
            return response()->json(['message'=>'maximum number of rooms exceeded']);
        }

        $room = Room::create($request->all());

        return response()->json(['message'=>'register created','room'=>$room]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room  = DB::table('rooms')
        ->select('rooms.id','rooms.amount','rooms.number','rooms.accommodations','rooms.type_room_id','type_rooms.name as type_rooms', 'rooms.user_created_id')
        ->join('type_rooms','type_rooms.id','=','rooms.type_room_id')
        ->where('rooms.id',$id)
        ->groupBy('rooms.id','type_rooms.name')
        ->get();

        $typeRoom = TypeRoom::find($room[0]->type_room_id);

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

        $repeatedRoom =Room::where('hotel_id',$request->hotel_id)->where('number',$request->number)->first();

        if ($repeatedRoom) {
            return response()->json(['message'=>'repeated room in the hotel']);
        }

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
