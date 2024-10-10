@extends('admin.master')
@section('title')
    Danh sach user
@endsection
@section('content')
    <h1>Danh sach user</h1>
    
    

    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th>User_ID</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                    
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->phone->value }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
@endsection
