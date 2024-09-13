@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    {{-- Page heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    </div>
    <div class="">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-title bg-dark text-white p-3 h5">New Admin Account</div>
                    <div class="card-body shadow-lg">
                        <form class="rounded p-3" action="{{route('profile#createAdminAccount')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label @error('name') is-invalid @enderror">Name</label>
                                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="Name">
                                @error('name')
                                    <small class="invalid-feedback text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label @error('email') is-invalid @enderror">Email</label>
                                <input type="text" class="form-control" name="email" id="exampleFormControlInput1" placeholder="Email">
                                @error('email')
                                    <small class="invalid-feedback text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label @error('newPassword') is-invalid @enderror">New Password</label>
                                <input type="text" class="form-control" name="newPassword" id="exampleFormControlInput1" placeholder="new password">
                                @error('newPassword')
                                    <small class="invalid-feedback text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label @error('confirmPassword') is-invalid @enderror">Confirm Password</label>
                                <input type="text" class="form-control" name="confirmPassword" id="exampleFormControlInput1" placeholder="confirm password">
                                @error('confirmPassword')
                                    <small class="invalid-feedback text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <input type="submit" class="btn btn-primary mt-3 w-100" value="Create Admin Account">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
