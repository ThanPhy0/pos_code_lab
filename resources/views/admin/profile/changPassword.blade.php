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
                    <div class="card-body shadow-lg">
                        <form class="rounded p-3" action="{{route('profile#changePassword')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label @error('currentPassword') is-invalid @enderror">Current Password</label>
                                <input type="text" class="form-control" name="currentPassword" id="exampleFormControlInput1" placeholder="current password">
                                @error('currentPassword')
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
                            <input type="submit" class="btn btn-primary mt-3" value="Change Password">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
