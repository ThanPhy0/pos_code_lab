@extends('user.layouts.master')

@section('content')
    <div class="container hero-header p-5" style="">
        <div class="row">
            <table class="table table-hover shadow-lg">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Order Code</th>
                        <th scope="col">Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myOrder as $items)
                        <tr>
                            <th>{{ $items->created_at->format('j-F-Y h:m A') }}</th>
                            <th>{{ $items->order_code }}</th>
                            <th>
                                @if ($items->status == 0)
                                    <span class="btn-sm btn-warning rounded shadow-lg">Pending</span>
                                @elseif ($items->status == 1)
                                    <span class="btn-sm btn-success rounded shadow-lg">Accept</span><span
                                        class="text-danger mx-2"><i class="fa-solid fa-hourglass-end"></i> Waiting Time <b>3
                                            days</b></span>
                                @else
                                    <span class="btn-sm btn-danger rounded shadow-lg">Reject</span>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
