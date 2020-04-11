<?php

namespace App\Http\Controllers;

use App\User;

class FriendController extends Controller
{
    public function members()
    {
        $users = User::all();

        return view('members', ['users' => $users]);
    }

    public function add(User $user)
    {
        if (auth()->user()->addFriend($user)) {
            return redirect('/')->with('friendAdded', $user->name);
        } else {
            return view('error', compact('user'));
        }
    }

    public function cancel(User $user)
    {
        if (auth()->user()->cancelFriendRequest($user)) {
            return redirect('/')->with('friendCanceled', $user->name);
        } else {
            return view('error', compact('user'));
        }
    }

    public function remove(User $user)
    {
        if (auth()->user()->removeFriend($user)) {
            return redirect('/')->with('friendRemoved', $user->name);
        } else {
            return view('error', compact('user'));
        }
    }

    public function accept(User $user)
    {
        if (auth()->user()->acceptFriend($user)) {
            return redirect('/')->with('friendAccepted', $user->name);
        } else {
            return view('error', compact('user'));
        }
    }

    public function decline(User $user)
    {
        if (auth()->user()->declineFriend($user)) {
            return redirect('/')->with('friendDeclined', $user->name);
        } else {
            return view('error', compact('user'));
        }
    }

    public function index(User $user)
    {
        $friends = $user->friends();
        return view('friend.index', ['friends' => $friends, 'user' => $user]);
    }

    public function pendingTo()
    {
        $pendingFriends = auth()->user()->pendingFriends();
        return view('friend.pending-to-you', ['pendingFriends' => $pendingFriends]);
    }

    public function pendingFrom()
    {
        $pendingFriends = auth()->user()->pendingFriendRequestsSent();
        return view('friend.pending-from-you', ['pendingFriends' => $pendingFriends]);
    }
}
