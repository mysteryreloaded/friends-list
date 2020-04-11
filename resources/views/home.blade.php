@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-6">
            <div class="card" style="height: 100%;">
            <div class="card-header" style="display:flex; justify-content: space-between; align-items: center; background-color: rgba(0, 0, 0, 0.03);"><span>Friends</span></div>
                {{-- @forelse (auth()->user()->friends as $friend) --}}
                    <div class="card-body border-bottom">
                        <div class="title">
                            <h2>
                                <a href="">
                                    {{-- {{ $friend->name }} --}}
                                </a>
                            </h2>
                        </div>
                    </div>
                {{-- @empty --}}
                    <p class="text-center pt-3">You have no friends yet :(</p>
                {{-- @endforelse --}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="height: 100%;">
            <div class="card-header" style="display:flex; justify-content: space-between; align-items: center; background-color: rgba(0, 0, 0, 0.03);"><span>Not Friends</span></div>
                {{-- @forelse (auth()->user()->friends as $friend) --}}
                    <div class="card-body border-bottom">
                        <div class="title">
                            <h2>
                                <a href="#">
                                    {{-- {{ $friend->name }} --}}
                                </a>
                            </h2>
                            <form action="#" method="">
                                @csrf
                                <button type="submit">
                                    {{-- {{ $friend->name }} --}}
                                </button>
                            </form>
                        </div>
                    </div>
                {{-- @empty --}}
                    <p class="text-center pt-3">You have added all friends, no more left to add.</p>
                {{-- @endforelse --}}
            </div>
        </div>
    </div>
</div>
@endsection
