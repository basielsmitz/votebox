@extends('master')
@section('title')
    Settings
@endsection
@section('navigation')
    <li  ><a href="/backoffice/">Dashboard</a></li>
    <li ><a href="/backoffice/users">Users</a></li>
    <li ><a href="/backoffice/parties">Parties</a></li>
    <li ><a href="/backoffice/referenda">Referenda</a></li>
    <li ><a href="/backoffice/groups">Groups</a></li>
    <li ><a href="/backoffice/elections">Elections</a></li>
@endsection
@section('navigation-right')
        <li class="active" ><a href="/backoffice/settings">Settings</a></li>
        <li ><a href="/backoffice/login">Login</a></li>
@endsection
@section('content')
    Settings
@endsection