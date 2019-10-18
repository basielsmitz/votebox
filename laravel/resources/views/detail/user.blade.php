@extends('master')
@section('title')
        {{ ucfirst(trans($user->username))}}
@endsection

@section('breadcrumb')
        <ol class="breadcrumb">
                <li><a href="/backoffice/users">Users</a></li>
                <li class="active" ><a href="/backoffice/users/{{$user->id}}">{{$user->name}}</a></li>
        </ol>
@endsection
@section('content')
    <div class="col-xs-12 col-sm-3">
        <img src="{{$user->pictureUri}}" width="100%">

    </div>

    <div class="col-xs-12 col-sm-9 userInfo">
        <h3>info</h3>
        <table class="table">
            <tbody>
            <tr>
                <th>name</th>
                <td>{{$user->firstname}} {{$user->lastname}}</td>
            </tr>
            <tr>
                <th>last login</th>
                <td>{{$user->lastLogin}}</td>
            </tr>
            <tr>
                <th>gender</th>
                <td>{{$user->gender}}</td>
            </tr>
            <tr>
                <th>age</th>
                <td>{{$age}}</td>
            </tr>
            </tbody>
        </table>
        <h3>groups</h3>
        @if(!$groups->isEmpty())
            <table class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>description</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $item)
                    <tr>
                        <td><a href="/backoffice/groups/{{$item->id}}">{{$item->id}}</a></td>
                        <td><a href="/backoffice/groups/{{$item->id}}">{{$item->name}}</a></td>
                        <td><a href="/backoffice/groups/{{$item->id}}">{{$item->description}}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @else
            <p>This user is not active in any groups</p>
        @endif

    </div>





@endsection