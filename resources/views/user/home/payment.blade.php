@extends('user.layouts.master')

@section('content')
    <div class="container hero-header p-5" style="margin-top: 350px;">
        <div class="row">
            <div class="card col-12 shadow-lg p-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <h5 class="mb-5">Payment Method</h5>
                            @foreach ($payment as $items)
                                <div class="">
                                    <b>{{ $items->type }}</b> (Name : {{ $items->account_name }})
                                </div>
                                Account : {{ $items->account_number }}
                                <hr>
                            @endforeach
                        </div>
                        <div class="col">
                            <div class="card shadow-lg">
                                <div class="card-header">
                                    Payment Info
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <form action="{{route('product#order')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="User Name" readonly value="{{Auth::user()->name}}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="phone" id="" class="form-control @error('phone') is-invalid @enderror"
                                                        placeholder="09xxxxxxxx" value="{{Auth::user()->phone}}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="address" id="" class="form-control @error('address') is-invalid @enderror"
                                                        placeholder="Address" value="{{Auth::user()->address}}">
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <select name="paymentType" id="" class="form-control @error('paymentType') is-invalid @enderror">
                                                        <option value="">Choose Payment Method</option>
                                                        @foreach ($payment as $items)
                                                            <option value="{{ $items->type }}" @if(old('paymentType') == $items->id) selected @endif>{{ $items->type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <input type="file" name="payslipImage" id=""
                                                        class="form-control @error('payslipImage') is-invalid @enderror">
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="hidden" name="orderCode" value="{{$orderProduct[0]['order_code']}}">
                                                    Order code : <span class="text-secondary fw-bold">{{$orderProduct[0]['order_code']}}</span>
                                                </div>
                                                <div class="col">
                                                    <input type="hidden" name="totalAmount" value="{{$orderProduct[0]['total_ammount']}}">
                                                    Total Amt : <span class="text-dark fw-bold">{{$orderProduct[0]['total_ammount']}}</span>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-outline-success w-100 mx-2"><i class="fa-solid fa-cart-shopping"></i> Order Now</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
