<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Message;
use App\Events\newMessage;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'post'], function(){
	Route::get('form', [App\Http\Controllers\PostController::class, 'form'])->name('Post.form');
	Route::post('save', [App\Http\Controllers\PostController::class, 'save'])->name('Post.save');

});

Route::get('test', function(){
	dd(User::all());
	dd(Message::all());
});

Route::get('chatWith/{id}', function($id){
	$my_id = Auth::user()->user_id;
	// $messages = Message::where('from', Auth::user()->user_id)->where('to', (int)$id)->get();
	$messages = Message::where(function($query) use ($my_id, $id){
		$query->where('from', $my_id)->where('to', (int)$id);
	})->orWhere(function($query) use ($my_id, $id){
		$query->where('from', (int)$id)->where('to', $my_id);
	})->get();
	foreach($messages as $m)
	{
		$m->update(['is_read' => 1]);
	}
	return view('chatWith', compact('messages'));
});	

// Route::get('/message/{id}', [App\Http\Controllers\HomeController::class, 'getMessage'])->name('message');
Route::post('/message', [App\Http\Controllers\HomeController::class, 'postMessage'])->name('postMessage');

Route::get('count', function(){
	$user = User::where('user_id', 2)->get();
	// dd($user);

	// foreach($user as $u)
	// {
	// 	dd($u->countUnreadMessage->where('from', 3)->count());
	// }
	$message = Message::where('to', 2)->where('from', 3)->get();
	dd($message);
}); // test