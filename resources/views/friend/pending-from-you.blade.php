@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pending Friend Requests Sent by You!</div>
                <div class="card-body">
                    @forelse ($pendingFriends as $friend)
                    <div class="alert alert-secondary" role="alert">
                        <p>{{ $friend->name }}</p>
                        <a href="{{ route('cancel-friend', $friend) }}" class="btn btn-secondary">Cancel friend request</a>
                    </div>
                    @empty
                    <div class="alert alert-danger" role="alert">
                        <p>There are no pending friend requests sent by you at this moment :(</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection