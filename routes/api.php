<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('home',function(){
	return ['home'=>\Wink\WinkPost::with('author')->latest()->get()->map(function($post){
$post->featured_image = url($post->featured_image);
$post->body = str_replace('"/storage/wink','"'.url('/storage/wink//'), $post->body);
$post->author->avatar = url($post->author->avatar);
return $post;})];
});
