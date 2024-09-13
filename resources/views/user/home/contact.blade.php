@extends('user.layouts.master')

@section('content')
    <div class="container-fluid hero-header p-5">
        <div class="row">
            <div class="col-6">
                <div class="card shadow-lg">
                    <div class="card-header">
                        Contact Me
                    </div>
                    <div class="card-body">
                        <div class="">
                            <form action="{{ route('toContact') }}" method="POST">
                                @csrf
                                <div>
                                    <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                    <input type="text" name="title" id=""
                                        class="form-control @error('address') is-invalid @enderror" placeholder="Title"
                                        value="">
                                </div>
                                <div class="mt-3">
                                    <textarea name="message" id="" class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Enter your message" cols="30" rows="10"></textarea>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-outline-success w-100 mx-2"><i
                                            class="fa-solid fa-cart-shopping"></i> Contact Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                @foreach ($contact_data as $items)
                    <div class="card shadow-lg mt-3">
                        <div class="card-header">
                            <div class="">
                                <h3>{{ $items->title }}</h3>
                                <h5>{{ Route::currentRouteName() }}</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>{{ $items->message }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
