@extends('admin.master')
@section('title')
    Chi tiết khach hang : {{ $customer->name }}
@endsection
@section('content')
    <h1>Chi tiết khach hang : {{ $customer->name }}</h1>
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">Tên Trường</th>
                    <th scope="col">Giá trị</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($customer->toArray() as $key => $value)
                    <tr>
                        <th scope="row">{{ $key }}</th>
                        <td>
                            @php
                                switch ($key) {
                                    case 'avatar':
                                        if ($value) {
                                            $url = Storage::url($value);
                                            echo '<img src="' . $url . '" width="100" alt="">';
                                        }
                                        break;

                                    case 'is_active':
                                        echo $value
                                            ? '<span class="badge bg-primary">Yes</span>'
                                            : '<span class="badge bg-danger">No</span>';
                                        break;

                                    default:
                                        echo $value;
                                        break;
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
