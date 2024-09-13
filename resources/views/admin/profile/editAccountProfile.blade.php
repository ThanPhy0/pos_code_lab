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
            <form action="{{route('profile#update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3 mr-5">
                            <img class="img-profile w-100" id="output" src="{{asset(Auth::user()->profile != null ? 'profile/' . Auth::user()->profile : 'admin/img/undraw_profile.svg')}}" alt="">
                            <div class="mb-3">
                                <input type="file" name="image" id="" class="form-control mt-3" onchange="loadFile(event)">
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Name" value="{{old('name', Auth::user()->name)}}">
                                        @error('name')
                                            <span class="invalid-feedback text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Email" value="{{Auth::user()->email, old('email')}}">
                                        @error('email')
                                            <span class="invalid-feedback text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Phone" value="{{Auth::user()->phone, old('phone')}}">
                                        @error('phone')
                                            <span class="invalid-feedback text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Address" value="{{Auth::user()->address, old('address')}}">
                                        @error('address')
                                            <span class="invalid-feedback text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
