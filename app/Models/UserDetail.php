<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = "users_detail";
    protected $primaryKey = "user_id";
    protected $fillable = ['user_id', 'status', 'position'];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
