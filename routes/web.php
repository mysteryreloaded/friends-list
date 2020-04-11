<?php

use Illuminate\Support\Facades\Route;

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

//  All routes require authentication!

// Default auto-generated Laravel routes for authentication
Auth::routes();

// Homepage route, returns 'members' view -> page where all registered members can be seen
Route::get('/', 'FriendController@members')->name('members')->middleware('auth');

// Pending to you route, returns 'friend.pending-to-you' view -> page where authenticated user
// can see all friend request he sent which have not been accepted, has option to cancel
Route::get('/friends/pending-to-you', 'FriendController@pendingTo')->name('pending-to-you')->middleware('auth');

// Pending from you route, returns 'friend.pending-from-you' view -> page where authenticated user
// can see all friend request he receieved, has option to accept or decline
Route::get('/friends/pending-from-you', 'FriendController@pendingFrom')->name('pending-from-you')->middleware('auth');

// Add friend route, returns 'members' view with a flash notification saying he added a new friend
// This route runs a command on User model which creates a new friendship
Route::get('/friends/add/{user}', 'FriendController@add')->name('add-friend')->middleware('auth');

// Cancel friend request route, returns 'members' view with a flash notification saying he
// canceled his friend request. This route runs a command on User model which deletes Friendship request he sent
Route::get('/friends/cancel/{user}', 'FriendController@cancel')->name('cancel-friend')->middleware('auth');

// Remove friend route, returns 'members' view with a flash notification saying he removed a friend
// This route runs a command on User model which deletes an existing Friendship
Route::get('/friends/remove/{user}', 'FriendController@remove')->name('remove-friend')->middleware('auth');

// Accept friend route, returns 'members' view with a flash notification saying he accepted a new friend
// This route runs a command on User model which changes status on Friendship from false to true
Route::get('/friends/accept/{user}', 'FriendController@accept')->name('accept-friend')->middleware('auth');

// Decline friend route, returns 'members' view with a flash notification saying he declined a friend request
// This route runs a command on User model which changes deletes Friendship with status false
Route::get('/friends/decline/{user}', 'FriendController@decline')->name('decline-friend')->middleware('auth');

// List all friends from a user, returns 'friend.index' view where all users frends can be seen
Route::get('/friends/{user}', 'FriendController@index')->name('list-friend')->middleware('auth');
