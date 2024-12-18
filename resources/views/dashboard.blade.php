@extends('app')

@section('content')
    @php
        $menus_name = 'Dashboard';
    @endphp

    @if(Session::get('role') === 'user')
        @include('client.users.dashboard')
    @elseif(Session::get('role') === 'admin')
        @include('client.admin.dashboard')
    @endif
@endsection
