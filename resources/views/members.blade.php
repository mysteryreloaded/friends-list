@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if(session('friendAdded'))
                    <div class="card-header">Friend Added!</div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            <h5>You have successfully sent a friend request to: {{ session()->get('friendAdded') }}!</h5>
                        </div>
                    </div>
                @endif
                @if(session('friendCanceled'))
                    <div class="card-header">Friend Request Canceled!</div>
                    <div class="card-body">
                        <div class="alert alert-danger">
                            <h5>You have successfully canceled friend request to: {{ session()->get('friendCanceled') }}!</h5>
                        </div>
                    </div>
                @endif
                @if(session('friendRemoved'))
                <div class="card-header">Friend Removed!</div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h5>You have successfully removed friend: {{ session()->get('friendRemoved') }}!</h5>
                    </div>
                </div>
                @endif
                @if(session('friendAccepted'))
                <div class="card-header">Friend Accepted!</div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <h5>You have successfully accepted friend: {{ session()->get('friendAccepted') }}!</h5>
                    </div>
                </div>
                @endif
                @if(session('friendDeclined'))
                <div class="card-header">Friend Declined!</div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h5>You have successfully declined friend: {{ session()->get('friendDeclined') }}!</h5>
                    </div>
                </div>
                @endif
                <div class="card-header">All Members List</div>

                <div class="card-body">
                    @forelse ($users as $user)
                    <div class="alert alert-secondary" role="alert">
                        <h4 class="mb-4">{{ $user->name }}</h4>
                        <div style="display: flex; justify-content: space-between">
                            @if(!auth()->user()->isFriendWith($user) && !$user->hasPendingFriendRequestsFrom(auth()->user()) && auth()->user() != $user)
                                <a href="{{ route('add-friend', $user) }}" class="btn btn-secondary">Add friend</a>
                            @endif
                            @if(auth()->user()->isFriendWith($user))
                                <a href="{{ route('remove-friend', $user) }}" class="btn btn-secondary">Remove friend</a>
                            @endif
                            @if(auth()->user()->hasPendingFriendRequestsFrom($user))
                                <a href="{{ route('accept-friend', $user) }}" class="btn btn-secondary">Accept friend request</a>
                                <a href="{{ route('decline-friend', $user) }}" class="btn btn-secondary">Decline friend request</a>
                            @endif
                            @if(auth()->user()->hasPendingFriendRequestsSentTo($user))
                                <a href="{{ route('cancel-friend', $user) }}" class="btn btn-secondary">Cancel friend request</a>
                            @endif
                            @if(auth()->user() != $user)
                                <a href="{{ route('list-friend', $user) }}" class="btn btn-secondary">See {{ $user->name }} friends</a>
                            @else
                                <a href="{{ route('list-friend', $user) }}" class="btn btn-secondary">See your friends</a>
                                <a href="{{ route('pending-to-you') }}" class="btn btn-secondary">Pending requests sent to you</a>
                                <a href="{{ route('pending-from-you') }}" class="btn btn-secondary">Pending requests sent by you</a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-danger" role="alert">
                        <p>No users at the moment :(</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection