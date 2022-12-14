<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'city',
        'address',
        'nit',
        'max_rooms',
        'user_created_id',
        'created_at',
        'updated_at'
    ];

    public function room(){
        return $this->hasMany(Room::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'user_created_id');
    }
}
