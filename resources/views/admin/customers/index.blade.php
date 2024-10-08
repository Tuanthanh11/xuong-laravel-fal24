@extends('admin.master')
@section('title')
    Danh sach khach hang
@endsection
@section('content')
    <h1>Danh sach khach hang</h1>
    @if (session()->has('success') && !session()->get('success'))  
        <div class="alert alert-danger">
            {{ $session->get('error') }}
        </div>
    @endif

    @if (session()->has('success') && session()->get('success'))  
        <div class="alert alert-success">
            Thao tac thanh cong
        </div>
    @endif
    <a href="{{ route('customers.create') }}" class="btn btn-primary">Create</a>

    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NAME</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">AVATAR</th>
                    <th scope="col">PHONE</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">IS_ACTIVE</th>
                    <th scope="col">CREATED AT</th>
                    <th scope="col">UPDATED AT</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $customer)
                    <tr>
                        <th scope="row">{{ $customer->id }}</th>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>
                            @if ($customer->avatar)
                                <img src="{{ Storage::url($customer->avatar) }}" width="100" alt="">
                            @endif
                        </td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            @if ($customer->is_active == 1)
                                <span class="badge bg-primary">Yes</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->updated_at }}</td>
                        <td>
                            <a href="{{ route('customers.show',$customer)}}" class="btn btn-info">SHOW</a>
                            <a href="{{ route('customers.edit',$customer)}}" class="btn btn-warning">EDIT</a>

                            <form action="{{ route('customers.destroy', $customer) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Co muon xoa khong')" class="btn btn-danger">XM</button>
                            </form>

                            <form action="{{ route('admin.customers.forveDestroy', $customer) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Co muon xoa khong')" class="btn btn-dark">XC</button>
                            </form>
                            
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        {{ $data->links() }}
    </div>
@endsection
