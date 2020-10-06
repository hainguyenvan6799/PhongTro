<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class User extends Eloquent implements Authenticatable
{
    use AuthenticatableTrait;
    use Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'mongodb';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function countUnreadMessage(){
        return $this->hasMany(Message::class, 'to', 'user_id')->where('is_read', 0)->where('to', Auth::user()->user_id);
    }
}
