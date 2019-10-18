@extends('master')
@section('title')
    Groups
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active" ><a href="/backoffice/groups">Groups</a></li>
    </ol>
@endsection
@section('content')
    <ul class=" pull-left list-inline">
        <li>
            <form action="/backoffice/groups">
                <input type="text" name="keyword" id="keyword">
                <input class="btn btn-default" type="submit" name="submit" value="Search">
            </form>
        </li>
        <li><a href="/backoffice/groups">reset filters</a> </li>
    </ul>
    <ul class="pull-right">
        <l1>
            <a class="btn btn-default" href="/backoffice/groups/create">New</a>
        </l1>
    </ul>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th colspan="3">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($groups as $item)
            <tr>
                <td><a href="/backoffice/groups/{{$item->id}}">{{$item->name}}</a></td>
                <td><a href="/backoffice/groups/{{$item->id}}">{{$item->description}}</a></td>
                <td><a href="/backoffice/groups/{{$item->id}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                <td><a href="/backoffice/groups/{{$item->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                <td>
                    <form id="delete_form{{$item->id}}" action="{{ URL::route('groups.destroy',$item->id) }}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="id" name="id" value="{{ $item->id}}">
                        <a onclick="return (confirm('Are you sure you want to delete group with id {{$item->id}}'))?document.getElementById('delete_form{{$item->id}}').submit():null" href="javascript:{}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$groups->links()}}
@endsection