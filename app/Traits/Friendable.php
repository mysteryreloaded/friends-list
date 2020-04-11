<?php

namespace App\Traits;

use App\Friendship;
use App\User;

trait Friendable
{
    public function friends()
    {
        $friends = array();

        $friendships = Friendship::where('status', 1)
            ->where('user_1', $this->id)
            ->get();

        foreach ($friendships as $friendship):
            array_push($friends, User::find($friendship->user_2));
        endforeach;

        $friends2 = array();

        $friendships2 = Friendship::where('status', 1)
            ->where('user_2', $this->id)
            ->get();

        foreach ($friendships2 as $friendship):
            array_push($friends2, User::find($friendship->user_1));
        endforeach;

        return array_merge($friends, $friends2);
    }

    public function friendsIds()
    {
        return collect($this->friends())->pluck('id')->toArray();
    }

    public function isFriendWith(User $user)
    {
        if (in_array($user->id, $this->friendsIds())) {
            return true;
        } else {
            return false;
        }
    }

    public function pendingFriends()
    {
        $pendingFriends = array();

        $friendships = Friendship::where('status', 0)
            ->where('user_2', $this->id)
            ->get();

        foreach ($friendships as $friendship):
            array_push($pendingFriends, User::find($friendship->user_1));
        endforeach;

        return $pendingFriends;
    }

    public function pendingFriendsIds()
    {
        return collect($this->pendingFriends())->pluck('id')->toArray();
    }

    public function pendingFriendRequestsSent()
    {
        $pendingRequests = array();

        $friendships = Friendship::where('status', 0)
            ->where('user_1', $this->id)
            ->get();

        foreach ($friendships as $friendship):
            array_push($pendingRequests, User::find($friendship->user_2));
        endforeach;

        return $pendingRequests;
    }

    public function pendingFriendRequestsSentIds()
    {
        return collect($this->pendingFriendRequestsSent())->pluck('id')->toArray();
    }

    public function hasPendingFriendRequestsFrom(User $user)
    {
        if (in_array($user->id, $this->pendingFriendsIds())) {
            return true;
        } else {
            return false;
        }
    }

    public function hasPendingFriendRequestsSentTo(User $user)
    {
        if (in_array($user->id, $this->pendingFriendRequestsSentIds())) {
            return true;
        } else {
            return false;
        }
    }

    public function addFriend(User $user)
    {
        if ($this->isFriendWith($user)) {
            return "You are already friends with user: " . $user->name . "!";
        }

        if ($this->id === $user->id) {
            return false;
        }

        if ($this->hasPendingFriendRequestsSentTo($user)) {
            return "You already sent a friend request to user: " . $user->name . "!";
        }

        if ($this->hasPendingFriendRequestsFrom($user)) {
            return $this->acceptFriend($user);
        }
        $friendship = Friendship::create([
            'user_1' => $this->id,
            'user_2' => $user->id,
        ]);

        if ($friendship) {
            return true;
        } else {
            return false;
        }
    }

    public function removeFriend(User $user)
    {
        if (!$this->isFriendWith($user)) {
            return "You are not friends with user: " . $user->name . ", you can't remove him!";
        }

        if ($this->id === $user->id) {
            return false;
        }

        $userExists = User::find($user->id);
        if ($userExists) {
            $oneWayFriendship = Friendship::where('user_1', $user->id)
                ->where('user_2', $this->id)
                ->delete();
            $secondWayFriendship = Friendship::where('user_1', $this->id)
                ->where('user_2', $user->id)
                ->delete();
            if ($oneWayFriendship || $secondWayFriendship) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function acceptFriend(User $user)
    {
        if (!$this->hasPendingFriendRequestsFrom($user)) {
            return false;
        }

        $friendship = Friendship::where('user_1', $user->id)
            ->where('user_2', $this->id)
            ->first();

        if ($friendship) {
            $friendship->update([
                'status' => 1,
            ]);

            return true;
        } else {
            return false;
        }
    }

    public function declineFriend(User $user)
    {
        if (!$this->hasPendingFriendRequestsFrom($user)) {
            return false;
        }

        $friendship = Friendship::where('user_1', $user->id)
            ->where('user_2', $this->id)
            ->first();

        if ($friendship) {
            $friendship->delete();
            return true;
        } else {
            return false;
        }
    }

    public function cancelFriendRequest(User $user)
    {
        if (!$this->hasPendingFriendRequestsSentTo($user)) {
            return false;
        }

        $friendship = Friendship::where('user_1', $this->id)
            ->where('user_2', $user->id)
            ->first();

        if ($friendship) {
            $friendship->delete();
            return true;
        } else {
            return false;
        }
    }
}
