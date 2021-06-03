<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyEmailUser extends Model
{
    use HasFactory;
    public $table = 'verify_email';
    public $fillable = [
      'token',
      'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id','users');
    }
}
