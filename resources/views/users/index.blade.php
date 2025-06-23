@extends('layouts.main')
@push('css')
 
@endpush
@section('content')
    <div class="row">
        <div class="col">
            <h6 class="mb-0 text-uppercase">{{$page_title}}</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="pill" href="#primary-pills-home" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="fadeIn animated bx bx-user-circle font-18 me-1"></i>
                                    </div>
                                    <div class="tab-title">Akun Pengguna</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item d-none" role="presentation">
                            <a class="nav-link" data-bs-toggle="pill" href="#primary-pills-profile" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class="fadeIn animated bx bx-buildings font-18 me-1"></i>
                                    </div>
                                    <div class="tab-title">Role</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item d-none" role="presentation">
                            <a class="nav-link" data-bs-toggle="pill" href="#primary-pills-contact" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon"><i class='fadeIn animated bx bx-shield-quarter font-18 me-1'></i>
                                    </div>
                                    <div class="tab-title">Permission</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="primary-pills-home" role="tabpanel">
                            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
                                <div class="col">
                                    <div class="card radius-15 border border-dashed border-primary shadow-none">
                                        <div class="card-body text-center">
                                            <div class="p-4 radius-15">
                                                <div class="bg-primary-light p-3 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 110px; height: 110px;">
                                                    <img src="{{asset('assets/images/avatars/user-create.png')}}" alt="" width="110" height="110">
                                                </div>
                                                <h5 class="mb-0 mt-3 text-primary">Buat user baru</h5>
                                                <p class="mb-4 text-muted">Tambah user baru ke sistem.</p>
                                                <a href="{{route('users.create')}}" class="btn btn-primary radius-15">Buat User</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($users as $user)
                                <div class="col">
                                    <div class="card radius-15 bg-info">
                                        <div class="card-body text-center">
                                            <div class="p-4 radius-15">
                                                <img src="{{asset('assets')}}/images/avatars/{{$user->avatar ?? 'user.png'}}" width="110" height="110" class="rounded-circle shadow p-1 bg-white" alt="">
                                                <h5 class="mb-0 mt-5 text-white">{{ucfirst($user->name)}}</h5>
                                                <p class="mb-3 text-white">Admin</p>
                                                <div class="list-inline contacts-social mt-3 mb-3"> 
                                                </div>
                                                <div class="d-flex {{ Auth::user()->id == $user->id ? 'justify-content-center' : '' }}"> 
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning radius-15 mx-2">Edit Profile</a>
                                                    @if (Auth::user()->id != $user->id)
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger radius-15">Delete Profile</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    
@endpush