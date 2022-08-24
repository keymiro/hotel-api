<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'accommodations',
        'description',
        'created_at',
        'updated_at'
    ];

    public function room(){
        return $this->hasMany(Room::class);
    }
}
