@extends('admin.layouts.master')

@section('content')
    {{-- Begin page content --}}
    <div class="container-fluid">
        <div class="">
            <div class="col-8 offset-2">
                <div class="d-flex justify-content-between my-3">
                    <form action="{{ route('order#saleInfo') }}" method="GET">
                        <div class="d-flex">
                            <select name="statusFilter" class="form-select statusChange">
                                <option value="" {{ old('statusFilter') === null ? 'selected' : '' }}>All</option>
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
                </div>
                <table class="table table-hover shadow-lg">
                    <thead class="table-primary text-dark">
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Order Code</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($soldItems as $items)
                            <tr>
                                <input type="hidden" name="" class="orderCode" value="{{ $items->order_code }}">
                                <td scope="col">{{ $items->created_at }}</td>
                                <td scope="col">
                                    @if ($items->status == 0)
                                    <a href="{{ route('order#details', $items->order_code) }}" class="text-dark btn-sm btn-warning rounded shadow-lg">{{ $items->order_code }}</a>
                                    @endif
                                    @if ($items->status == 1)
                                    <a href="{{ route('order#details', $items->order_code) }}" class="text-white btn-sm btn-success rounded shadow-lg">{{ $items->order_code }}</a>
                                    @endif
                                    @if ($items->status == 2)
                                    <a href="{{ route('order#details', $items->order_code) }}" class="text-white btn-sm btn-danger rounded shadow-lg">{{ $items->order_code }}</a>
                                    @endif
                                </td>
                                <td scope="col">{{ $items->user_name }}</td>
                                <td>
                                    @if ($items->status == 0)
                                        <span class=""><i class="fa-solid fa-hourglass-end text-warning"></i></span>
                                    @endif
                                    @if ($items->status == 1)
                                        <span class=""><i class="fa-regular fa-circle-check text-success"></i></span>
                                    @endif
                                    @if ($items->status == 2)
                                        <span class=""><i class="fa-regular fa-circle-xmark text-danger"></i></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <span class="d-flex justify-content-end">{{$categories->links()}}</span> --}}
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('.statusChange').change(function() {
                $changeStatus = $(this).val();
                $orderCode = $(this).parents('tr').find('.orderCode').val();

                $data = {
                    'status': $changeStatus,
                    'order_code': $orderCode
                }

                $.ajax({
                    type: 'get',
                    url: '/admin/order/changeStatus',
                    data: $data,
                    dataType: 'json',
                    success: function(response) {
                        response.status == 'success' ? location.reload() : ''
                    }
                })
            })
        })
    </script>
@endsection
