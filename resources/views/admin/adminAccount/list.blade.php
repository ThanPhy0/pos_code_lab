@extends('admin.layouts.master')

@section('content')
    {{-- Begin page content --}}
    <div class="container-fluid">
        <div class="">

            <div class="col-10 offset-1">
                <div class="my-2 d-flex justify-content-between">
                    <a href="{{route('profile#userList')}}" class="btn btn-danger text-white"><i class="fa-solid text-white fa-users"></i> User List</a>
                    @php
                        $routeName = Route::currentRouteName();
                    @endphp
                    <form action="{{$routeName == 'profile#adminList' ? route('profile#adminList') : route('profile#userList')}}" method="GET">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" name="searchKey" id="" placeholder="Search!">
                            <button class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
                <table class="table table-hover shadow-lg">
                    <thead class="table-primary text-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Created Date</th>
                            <th scope="col">Role</th>
                            <th scope="col">Platform</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $routeName = Route::currentRouteName();
                        @endphp
                        @if ($routeName == 'profile#adminList')
                            @foreach ($admin as $data)
                                <tr>
                                    <th>{{$data->id}}</th>
                                    <th>{{$data->name}}</th>
                                    <th>{{$data->email}}</th>
                                    <th>{{$data->address}}</th>
                                    <th>{{$data->phone}}</th>
                                    <th>{{$data->created_at}}</th>
                                    <th><span class="bg-danger text-white p-1 rounded shadow-lg">{{$data->role}}</span></th>
                                    <th>
                                        @if($data->provider == 'google') <i class="fa-brands text-primary fa-google"></i> @endif
                                        @if($data->provider == 'github') <i class="fa-brands text-primary fa-github"></i> @endif
                                        @if($data->provider == 'simple') <i class="fa-solid text-primary fa-right-to-bracket"></i> @endif
                                    </th>
                                    <th>
                                        @if ($data->role != 'superadmin')
                                            <a href="{{route('profile#delete', $data->id)}}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                        @endif
                                    </th>
                                </tr>
                            @endforeach
                            @elseif ($routeName == 'profile#userList')
                            @foreach ($user as $data)
                            <tr>
                                <th>{{$data->id}}</th>
                                <th>{{$data->name}}</th>
                                <th>{{$data->email}}</th>
                                <th>{{$data->address}}</th>
                                <th>{{$data->phone}}</th>
                                <th>{{$data->created_at}}</th>
                                <th><span class="bg-success text-white p-1 rounded shadow-lg">{{$data->role}}</span></th>
                                <th>
                                    @if($data->provider == 'google') <i class="fa-brands text-primary fa-google"></i> @endif
                                    @if($data->provider == 'github') <i class="fa-brands text-primary fa-github"></i> @endif
                                    @if($data->provider == 'simple') <i class="fa-solid text-primary fa-right-to-bracket"></i> @endif
                                </th>
                                <th>
                                    @if ($data->role != 'superadmin')
                                        <a href="{{route('profile#delete', $data->id)}}" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></a>
                                    @endif
                                </th>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                {{-- <span class="d-flex justify-content-end">{{$categories->links()}}</span> --}}
            </div>
        </div>
    </div>
</div>
@endsection
