@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card col-5 shadow-lg m-4 col">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Name :</div>
                        <div class="col-7">{{ $payslipData->user_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Phone :</div>
                        <div class="col-7">
                            @if ($payslipData->phone != $order[0]->user_phone)
                                {{ $payslipData->phone }} /
                            @endif  {{ $order[0]->user_phone }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Address :</div>
                        <div class="col-7">{{ $payslipData->address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Code :</div>
                        <div class="col-7" id="orderCode">{{ $payslipData->order_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Date :</div>
                        <div class="col-7">{{ $order[0]->created_at->format('j-F-Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Total Price :</div>
                        <div class="col-7">
                            {{ $payslipData->total_amt }}
                            <small class="text-danger ms-2">(Contain Delivery Charges!)</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-5 shadow-lg m-4 col">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5">Contact Name :</div>
                        <div class="col-7">{{ $payslipData->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Payment Method :</div>
                        <div class="col-7">{{ $payslipData->payment_method }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Purchase Date :</div>
                        <div class="col-7">{{ $payslipData->created_at->format('j-F-Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <img style="width: 150px;" src="{{ asset('payslip/' . $payslipData->payslip_image) }}"
                            alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="m-0 font-weight-bold text-primary">Order Board</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover shadow-sm" id="productTable" width="100%" cellspacing = "0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Count</th>
                                    <th>Available Stock</th>
                                    <th>Product Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order as $items)
                                    <tr>
                                        <input type="hidden" class="productId" value="{{ $items->product_id }}">
                                        <input type="hidden" class="productOrderCount" value="{{ $items->order_count }}">
                                        <td>
                                            <img src="{{ asset('product/' . $items->product_image) }}"
                                                style="width: 100px;" alt="" class="img-thumbnail">
                                        </td>
                                        <td>{{ $items->product_name }}</td>
                                        <td>{{ $items->order_count }} @if ($items->available_stock < $items->order_count)
                                                <span class="sm-text text-danger">(out of stock)</span>
                                            @endif
                                        </td>
                                        <td>{{ $items->available_stock }}</td>
                                        <td>{{ $items->product_price }}</td>
                                        <td>{{ $items->order_count * $items->product_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <div class="d-flex">
                        <input id="btn-order-confirm" @if (!$status) disabled @endif
                            class="form-control btn btn-success shadow-sm rounded mr-2" value='Confirm'>
                        <input id="btn-order-reject" class="form-control btn btn-danger shadow-sm rounded" value='Reject'>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('#btn-order-confirm').click(function() {
                $orderList = [];
                $orderCode = $('#orderCode').text();

                $('#productTable tbody tr').each(function(index, row) {
                    $productId = $(row).find('.productId').val();
                    $productOrderCount = $(row).find('.productOrderCount').val();

                    $orderList.push({
                        'product_id': $productId,
                        'order_count': $productOrderCount,
                        'order_code': $orderCode
                    });
                });

                $.ajax({
                    type: 'get',
                    url: '/admin/order/confirmOrder',
                    data: Object.assign({}, $orderList),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            location.href = '/admin/order/list'
                        }
                    }
                });
                // console.log($orderList);
            });

            $('#btn-order-reject').click(function() {
                $data = {
                    'order_code': $('#orderCode').text()
                }

                $.ajax({
                    type: 'get',
                    url: '/admin/order/rejectOrder',
                    data: $data,
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 'success'){
                            location.href = '/admin/order/list'
                        }
                    }
                });
            });
        })
    </script>
@endsection


{{-- <div class="d-flex justify-content-between my-3">
    <form action="{{ route('order#saleInfo') }}" method="GET">
        <div class="d-flex">
            <select name="statusFilter" class="form-select statusChange">
                <option value="0" {{ old('statusFilter') == '0' ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ old('statusFilter') == '1' ? 'selected' : '' }}>Accept</option>
                <option value="2" {{ old('statusFilter') == '2' ? 'selected' : '' }}>Reject</option>
            </select>
            <button type="submit" class="btn-sm btn-primary shadow-lg ms-1">Search</button>
        </div>
    </form>
    <div>
        <form action="{{ route('order#saleInfo') }}" method="GET">
            <input type="text" class="form-control" name="searchKey" placeholder="Enter your . . . "
                id="">
        </form>
    </div>
</div> --}}
