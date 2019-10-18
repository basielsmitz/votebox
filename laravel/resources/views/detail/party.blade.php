@extends('master')
@section('title')
    {{ ucfirst(trans($party->name))}} Detail
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/backoffice/parties">Parties</a></li>
        <li class="active" ><a href="/backoffice/parties/{{$party->id}}">{{$party->name}}</a></li>
    </ol>
@endsection
@section('content')
    <div class="col col-xs-3 detail-page-head-image">
        <figure>
            <img src="{{$party->pictureUri}}" alt="party logo">
        </figure>
    </div>
    <div class="col col-xs-9">
        <h3>Description</h3>
        <p>{{$party->description}}</p>
        <form action="{{ URL::route('parties.destroy',$party->id) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <a class="btn btn-default" href="/backoffice/parties/{{$party->id}}/edit">Edit</a>
            <button onclick="return confirm('Are you sure you want to delete this party')" class="btn btn-danger">Delete</button>
        </form>
    </div>
    <div class="col col-xs-12">
        <h3> {{$candidates->total()}} Candidates</h3>
        <table class="table">
            <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>E-mail</th>
                <th>Birthday</th>
                <th>Gender</th>
            </tr>
            </thead>
            <tbody>
            @foreach($candidates as $item)
                <tr>
                    <td><a href="/backoffice/users/{{$item->user->id}}">{{$item->user->firstname}}</a></td>
                    <td><a href="/backoffice/users/{{$item->user->id}}">{{$item->user->lastname}}</a></td>
                    <td><a href="/backoffice/users/{{$item->user->id}}">{{$item->user->email}}</a></td>
                    <td><a href="/backoffice/users/{{$item->user->id}}">{{$item->user->birthdate}}</a></td>
                    <td><a href="/backoffice/users/{{$item->user->id}}">{{$item->user->gender}}</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$candidates->links()}}
    </div>
@endsection