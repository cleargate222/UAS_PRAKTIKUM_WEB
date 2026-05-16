<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'login_at'];

    // Hubungkan login history dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
