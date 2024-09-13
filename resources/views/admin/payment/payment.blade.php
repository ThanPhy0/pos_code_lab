@extends('admin.layouts.master')

@section('content')
    {{-- Begin page content --}}
    <div class="container-fluid">
        {{-- Page heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1>Payment Method</h1>
        </div>
        <div class="">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body shadow-lg">
                            <form class="rounded p-3" action="{{ route('payment#create') }}" method="POST">
                                @csrf
                                <input type="text" class="form-control @error('paymentType') is-invalid @enderror"
                                    name="paymentType" placeholder="Payment Type" id="">
                                @error('paymentType')
                                    <small class="invalid-feedback text-danger">{{ $message }}</small>
                                @enderror
                                <input type="text" class="form-control mt-3 @error('paymentName') is-invalid @enderror"
                                    name="paymentName" placeholder="Account Name" id="">
                                @error('paymentName')
                                    <small class="invalid-feedback text-danger">{{ $message }}</small>
                                @enderror
                                <input type="text" class="form-control mt-3 @error('paymentNumber') is-invalid @enderror"
                                    name="paymentNumber" placeholder="Account Number" id="">
                                @error('paymentNumber')
                                    <small class="invalid-feedback text-danger">{{ $message }}</small>
                                @enderror
                                <input type="submit" class="btn btn-outline-primary w-100 mt-3" value="Create">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <table class="table table-hover shadow-lg">
                        <thead class="table-primary text-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Type</th>
                                <th scope="col">Account Name</th>
                                <th scope="col">Account Number</th>
                                <th scope="col">Create Date</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($payments) != 0)
                                @foreach ($payments as $items)
                                    <tr>
                                        <th>{{$items->id}}</th>
                                        <th>{{$items->type}}</th>
                                        <th>{{$items->account_name}}</th>
                                        <th>{{$items->account_number}}</th>
                                        <th>{{$items->created_at->format('j-F-Y')}}</th>
                                        <th></th>
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
                    {{-- <span class="d-flex justify-content-end">{{ $categories->links() }}</span> --}}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
