@extends('master')
@section('title')
    Elections
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active" ><a href="/backoffice/elections">Elections</a></li>
    </ol>
@endsection
@section('content')
    <ul class="list-inline pull-left">
        <li>
            <form action="/backoffice/elections">
                <label for="keyword">status:</label>
                <select name="keyword" onchange="this.form.submit()">
                    <option <?php if($_GET){ if ($_GET['keyword'] == 'all') { ?>selected="true" <?php }}; ?> value="all">all</option>
                    <option <?php if($_GET){ if ($_GET['keyword'] == 'open') { ?>selected="true" <?php }}; ?> value="open">open</option>
                    <option <?php if($_GET){ if ($_GET['keyword'] == 'closed') { ?>selected="true" <?php }}; ?> value="closed">closed</option>
                    <option <?php if($_GET){ if ($_GET['keyword'] == 'coming') { ?>selected="true" <?php }}; ?> value="coming">coming</option>
                </select>
            </form>
        </li>
        <li>
            <form action="/backoffice/elections">
                <input type="text" name="keyword" id="keyword">
                <input class="btn btn-default" type="submit" name="submit" value="Search">
            </form>
        </li>
        <li><a href="/backoffice/elections">reset filters</a> </li>

    </ul>
    <ul class="pull-right">
        <l1>
            <a class="btn btn-default" href="/backoffice/elections/create">New</a>
        </l1>
    </ul>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>status</th>
            <th colspan="3">actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($elections as $item)
            <tr>
                <td><a href="/backoffice/elections/{{$item->id}}">{{$item->id}}</a></td>
                <td><a href="/backoffice/elections/{{$item->id}}">{{$item->name}}</a></td>
                <td><a href="/backoffice/elections/{{$item->id}}">{{$item->description}}</a></td>
                <td><a href="/backoffice/elections/{{$item->id}}">{{$item->isClosed? "Closed": "Open"}}</a></td>
                <td><a href="/backoffice/elections/{{$item->id}}/edit"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                <td><a href="/backoffice/elections/{{$item->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                <td>
                    <form id="delete_form{{$item->id}}" action="{{ URL::route('elections.destroy',$item->id) }}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="id" name="id" value="{{ $item->id}}">
                        <a onclick="return (confirm('Are you sure you want to delete referendum with id {{$item->id}}'))?document.getElementById('delete_form{{$item->id}}').submit():null" href="javascript:{}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$elections->links()}}
@endsection
