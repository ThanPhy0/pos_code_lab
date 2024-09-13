@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h4 class="m-0 font-weight-bold text-primary">Account Information</h4>
                    </div>
                </div>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 mr-5">
                            <img class="img-profile w-100" id="output"
                                src="{{ asset(Auth::user()->profile == null ? 'admin/img/undraw_profile.svg' : 'profile/' . Auth::user()->profile) }}"
                                alt="">
                        </div>
                        <div class="col">
                            <div class="row mt-3">
                                <div class="col-1 h5">Name : </div>
                                <div class="col h5">
                                    {{ Auth::user()->name == null ? Auth::user()->nickname : Auth::user()->name }}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-1 h5">Email : </div>
                                <div class="col h5">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-1 h5">Phone : </div>
                                <div class="col h5">{{ Auth::user()->phone }}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-1 h5">Role : </div>
                                <div class="col h5 text-danger">{{ Auth::user()->role }}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="d-flex">
                                    <a href="{{ route('profile#changPassword#page') }}" class="btn btn-dark mr-3"><i
                                            class="fa-solid fa-lock px-2"></i>Change Password</a>
                                    <a href="{{ route('profile#edit') }}" class="btn btn-primary"><i
                                            class="fa-solid fa-user-pen px-2"></i>Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
