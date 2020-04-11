@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(auth()->user() == $user)
                    <div class="card-header">Your friends list</div>
                @else
                    <div class="card-header">{{ $user->name }} - Friends list</div>
                @endif
                <div class="card-body">
                    @forelse ($friends as $friend)
                    <div class="alert alert-primary" role="alert">
                        <p>{{ $friend->name }}</p>
                        @if(auth()->user()->isFriendWith($friend))
                            <a href="{{ route('remove-friend', $friend) }}" class="btn btn-secondary">Remove friend</a>
                        @endif
                    </div>
                    @empty
                    <div class="alert alert-danger" role="alert">
                        @if(auth()->user() == $user)
                            <p>You have no friends at this moment :(</p>
                        @else
                            <p>{{ $user->name }} has no friends at this moment :(</p>
                        @endif
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection