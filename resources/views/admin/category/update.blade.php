@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    {{-- Page heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1>Category Update</h1>
    </div>
    <div class="">
        <div class="row">
            <div class="col-4">
                <a href="{{route('category#list')}}" class="btn btn-primary mb-3">Back</a>
                <div class="card">
                    <div class="card-body shadow-lg">
                        <form class="rounded p-3" action="{{route('category#update', $category->id)}}" method="POST">
                            @csrf
                            <input type="text" class="form-control @error('categoryName') is-invalid @enderror" value="{{$category->name, old('categoryName')}}" name="categoryName" placeholder="Category Name" id="">
                            @error('categoryName')
                                <small class="invalid-feedback text-danger">{{$message}}</small>
                            @enderror
                            <input type="submit" class="btn btn-outline-primary mt-3" value="Update">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
