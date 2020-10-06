<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
	protected $connection = 'mongodb';
	protected $guarded = [];
	// protected $fillable = ['title', 'content', 'created_by'];

}
