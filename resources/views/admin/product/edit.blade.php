@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        {{-- Page heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-1">
        </div>
        <div class="">
            <div class="row">
                <div class="col-6 offset-3">
                    <div class="card">
                        <div class="card-body shadow-lg">
                            <form class="rounded p-3" action="{{ route('update', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="oldPhoto" value="{{ $product->image }}">
                                <input type="hidden" name="productId" value="{{ $product->id }}">
                                <div>
                                    <img src="{{ asset('product/' . $product->image) }}" class="img-thumbnail w-100 h-20"
                                        id="output" alt="">
                                </div>
                                <div class="mb-3">
                                    <input type="file" name="image"
                                        class="form-control mt-3 @error('image') is-invalid @enderror"
                                        onchange="loadFile(event)" value="{{ $product->image }}">
                                    @error('image')
                                        <small class="invalid-feedback text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1"
                                                class="form-label @error('name') is-invalid @enderror">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                id="exampleFormControlInput1" value="{{ old('name', $product->name) }}"
                                                placeholder="Name">
                                            @error('name')
                                                <small class="invalid-feedback text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1"
                                                class="form-label @error('email') is-invalid @enderror">Category
                                                Name</label>
                                            <select class="form-select @error('categoryID') is-invalid @enderror"
                                                aria-label="Default select example" name="categoryID">
                                                <option value="">Choose Category</option>
                                                @foreach ($categories as $items)
                                                    <option value="{{ $items->id }}"
                                                        @if($product->category_id == $items->id) selected @endif>
                                                        {{ $items->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('categoryID')
                                                <small class="invalid-feedback text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1"
                                                class="form-label @error('price') is-invalid @enderror">Price</label>
                                            <input type="text" class="form-control" name="price"
                                                id="exampleFormControlInput1" value="{{ old('price', $product->price) }}"
                                                placeholder="MMK">
                                            @error('price')
                                                <small class="invalid-feedback text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1"
                                                class="form-label @error('stock') is-invalid @enderror">Stock</label>
                                            <input type="text" class="form-control" name="stock"
                                                id="exampleFormControlInput1" value="{{ old('stock', $product->stock) }}"
                                                placeholder="XXX">
                                            @error('stock')
                                                <small class="invalid-feedback text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1"
                                        class="form-label @error('description') is-invalid @enderror">Description</label>
                                    <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <small class="invalid-feedback text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <input type="submit" class="btn btn-primary mt-3 w-100" value="Update">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
