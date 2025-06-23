@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card radius-15 bg-info">
                <div class="card-body text-center">
                    <div class="p-4 radius-15">
                        <img src="{{ asset('assets/images/avatars/' . ($user->avatar ?? 'user.png')) }}" 
                             width="110" height="110" 
                             class="rounded-circle shadow p-1 bg-white" alt="">
                        <h5 class="mb-0 mt-3 text-white">{{ ucfirst($user->name) }}</h5>
                        <p class="mb-3 text-white">Admin</p>

                        <div class="mt-4">
                            <p class="text-white"><strong>Username:</strong> {{ $user->username }}</p>
                            <p class="text-white"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="text-white"><strong>Joined At:</strong> {{ $user->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <a href="{{ route('users.index') }}" class="btn btn-light radius-15 mx-2">Back</a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning radius-15 mx-2">Edit Profile</a>
                            @if (Auth::user()->id != $user->id)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger radius-15 mx-2">Delete</button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
