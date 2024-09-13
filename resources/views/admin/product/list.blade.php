@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between my-3">
            <div>
                <button class="btn btn-secondary rounded shadow-lg"><i class="fa-solid fa-database mr-2"></i>Product Count ({{count($product)}})</button>
                <a class="btn btn-primary" href="{{route('product#list')}}">All Product</a>
                <a class="btn btn-danger" href="{{route('product#list', 'amt')}}">Low Ammount Product</a>
            </div>
            <div class="">
                <form action="{{route('product#list')}}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control"
                            placeholder="Enter to search">
                        <button type="submit" class="btn bg-dark text-white"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-lg">
                    <thead class="table-primary text-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Category</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($product) != 0)
                            @foreach ($product as $items)
                                <tr>
                                    <th>{{ $items->id }}</th>
                                    <th>
                                        <img class="img-thumbnail shadow-sm" src="{{ asset('product/' . $items->image) }}"
                                            style="width: 100px;" alt="">
                                    </th>
                                    <th>{{ $items->name }}</th>
                                    <td>{{ $items->price }}</td>
                                    <th>
                                        <button type="button" class="btn btn-primary position-relative">
                                            {{ $items->stock }}
                                            @if ($items->stock <= 3)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    amt low
                                                </span>
                                            @endif
                                        </button>
                                    </th>
                                    <th>{{ $items->categories_name }}</th>
                                    <th>
                                        <a class="btn btn-outline-primary" href="{{route('view', $items->id)}}"><i
                                                class="fa-solid fa-eye"></i></a>
                                        <a class="btn btn-outline-secondary" href="{{route('update#list', $items->id)}}"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a class="btn btn-outline-danger" href="{{route('delete', $items->id)}}"><i
                                                class="fa-solid fa-trash"></i></a>
                                    </th>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <h5 class="text-center">There is no data!</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{-- <span class="d-flex justify-content-end">{{$product->links()}}</span> --}}
            </div>
        </div>
    </div>
@endsection
