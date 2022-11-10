<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $table = 'friendships';

    protected $fillable = [
        'user_id',
        'friend_id',
        'accepted'
    ];

    public function user1() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function user2() {
        return $this->belongsTo('App\Models\User', 'friend_id');
    }
}
