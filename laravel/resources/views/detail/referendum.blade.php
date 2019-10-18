@extends('master')
@section('title')
    {{ ucfirst(trans($referendum->title))}} Detail
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="../referenda">Referenda</a></li>
        <li class="active" ><a href="/referenda/{{$referendum->id}}">{{$referendum->title}}</a></li>
    </ol>

@endsection
@section('content')
    <div class="col-xs-12 col-sm-9">
        @if($referendum->isClosed)
            <h4>Status: Closed</h4>
            <h3>results</h3>
            <p>{{$referendum->description}}</p>

            <ul>
                <li>agree:{{$agree}}</li>
                <li>disagree:{{$disagree}}</li>
                <li>total:{{$total}}</li>
            </ul>
            <div id="results-chart"></div>
        @else
            <h4>Status: Open</h4>
            <h3>Referendum</h3>
            <p>{{$referendum->description}}</p>
        @endif
    </div>

    <div class="col-xs-12 col-sm-3 userInfo">
        <h3>info</h3>
        <table class="table">
            <tbody>
            <tr>
                <th>name</th>
                <td>{{$referendum->title}}</td>
            </tr>
            <tr>
                <th>created by</th>
                <td>{{$votemanager->username}}</td>
            </tr>
            <tr>
                <th>group</th>
                <td>{{$group->name}}</td>
            </tr>
            <tr>
                <th>started on</th>
                <td>{{$referendum->startDate}}</td>
            </tr>
            <tr>
                <th>ends on</th>
                <td>{{$referendum->endDate}}</td>
            </tr>
            <tr>
                <th>time left</th>
                {{--TODO: Countdown--}}
                <td></td>
            </tr>

            </tbody>
        </table>
        <form action="{{ URL::route('referenda.destroy',$referendum->id) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <a class="btn btn-default" href="/backoffice/referenda/{{$referendum->id}}/edit">Edit</a>
            <button onclick="return confirm('Are you sure you want to delete this referendum')" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
       var morris = new Morris.Donut({
            element: 'results-chart',

            data: [
                {label: "agreed", value:{{ $agree}}},
                {label: "disagreed", value:{{$disagree}}}
            ],

           colors: ["#347C90", "#C34F33"]
        });
    </script>
@endsection