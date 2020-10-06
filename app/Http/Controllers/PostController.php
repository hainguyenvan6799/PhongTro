<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public function form(){
    	return view('Post.form');
    }

    public function save(Request $request)
    {
    	$data = new Post($request->all());
    	$data->created_by = Auth::user()->email;
    	$data->save();
    }
}
