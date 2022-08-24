<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'number',
        'amount',
        'type_room_id',
        'hotel_id',
        'accommodations',
        'user_created_id',
        'created_at',
        'updated_at'
    ];

    public function type_room(){
        return $this->belongsTo(TypeRoom::class,'type_room_id');
    }

    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_created_id');
    }

}
