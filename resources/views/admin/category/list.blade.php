@extends('admin.layouts.master')

@section('content')
    {{-- Begin page content --}}
    <div class="container-fluid">
        {{-- Page heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1>Category List</h1>
        </div>
        <div class="">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body shadow-lg">
                            <form class="rounded p-3" action="{{ route('category#create') }}" method="POST">
                                @csrf
                                <input type="text" class="form-control @error('categoryName') is-invalid @enderror"
                                    name="categoryName" placeholder="Category Name" id="">
                                @error('categoryName')
                                    <small class="invalid-feedback text-danger">{{ $message }}</small>
                                @enderror
                                <input type="submit" class="btn btn-outline-primary mt-3" value="Create">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <table class="table table-hover shadow-lg">
                        <thead class="table-primary text-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created At</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($categories) != 0)
                                @foreach ($categories as $items)
                                    <tr>
                                        <th>{{ $items->id }}</th>
                                        <td>{{ $items->name }}</td>
                                        <td>{{ $items->created_at->format('j-F-Y') }}</td>
                                        <td>
                                            <a href="{{ route('category#updatePage', $items->id) }}"
                                                class="btn btn-outline-primary mr-3"><i
                                                    class="fa-solid fa-pen-to-square text-dark"></i></a>
                                            <a href="{{ route('category#delete', $items->id) }}"
                                                class="btn btn-outline-primary"><i
                                                    class="fa-solid fa-trash text-danger"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th colspan="4">
                                        <h5 class="text-center">There is no data!</h5>
                                    </th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <span class="d-flex justify-content-end">{{ $categories->links() }}</span>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
