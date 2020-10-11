@extends('layouts.index')
@section('content')
    <table class="table mt-5">
        <thead>
        <tr>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->phone_number}}</td>
            <td><button title="Nhắn tin"><a  href="/messages/{{$user->username}}"><i class="fas fa-comment-dots"></i></a></button></td>
            @if (Auth::user()->level == 1)
            <td><button title="Sửa thông tin"><a href="/user/getEdit/{{$user->username}}"><i class="fas fa-user-edit"></i></a></button></td>
            <td><button title="Xóa tài khoản"><a href="/user/dele/{{$user->username}}"><i class="far fa-trash-alt"></i></a></button></td>
            @endif
        </tr>
        </tbody>
    </table>
@endsection
