@extends('master')
@section('title')
    {{ ucfirst(trans($election->name))}}

@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/backoffice/elections">Elections</a></li>
        <li class="active" ><a href="/backoffice/elections/{{$election->id}}">{{$election->name}}</a></li>
    </ol>
@endsection
@section('content')

    <div class="col-xs-12 col-sm-9">
        @if($election->startDate > \Carbon\Carbon::now())
            <h4>Status: <span class="status-closed">Closed</span></h4>
        @if(count($election->candidates) !=0 )
            @if($election->candidates[0]->pivot->approved)
                    <h3>Candidates</h3>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>party</th>
                            <th>unapprove</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($election->candidates as $candidate)
                            @if($candidate->pivot->approved)
                                <tr>
                                    <td><a href="/backoffice/users/{{$candidate->user_id}}">{{$candidate->id}}</a></td>
                                    <td><a href="/backoffice/users/{{$candidate->user_id}}">{{$candidate->user->firstname}} {{$candidate->user->lastname}}</a></td>
                                    <td><a href="/backoffice/parties/{{$candidate->party->id}}">{{$candidate->party->name}}</a></td>
                                    <td>
                                        <form id="unapprove_form{{$candidate->id}}" action="{{ URL::route('candidate.unapprove',['election' => $election->id, 'candidate' => $candidate->id ] ) }}" method="POST">
                                            <input type="hidden" name="_method" value="PATCH">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" id="id" name="id" value="{{ $candidate->id}}">
                                            <a onclick="return (confirm('Are you sure you want to unapprove candidate with id {{$candidate->id}}'))?document.getElementById('unapprove_form{{$candidate->id}}').submit():null" href="javascript:{}">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No Candidates have been approved for this election</p>
                @endif

                @if(count($unapproved) !=0 )
                    <h3>Unapproved candidates</h3>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>party</th>
                            <th>approve</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($unapproved as $candidate)
                            <tr>
                                <td><a href="/backoffice/users/{{$candidate->user_id}}">{{$candidate->id}}</a></td>
                                <td><a href="/backoffice/users/{{$candidate->user_id}}">{{$candidate->user->firstname}} {{$candidate->user->lastname}}</a></td>
                                <td><a href="/backoffice/parties/{{$candidate->party->id}}">{{$candidate->party->name}}</a></td>
                                <td>
                                    <form id="approve_form{{$candidate->id}}" action="{{ URL::route('candidate.approve',['election' => $election->id, 'candidate' => $candidate->id ] ) }}" method="POST">
                                        <input type="hidden" name="_method" value="PATCH">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" id="id" name="id" value="{{ $candidate->id}}">
                                        <a onclick="return (confirm('Are you sure you want to approve candidate with id {{$candidate->id}}'))?document.getElementById('approve_form{{$candidate->id}}').submit():null" href="javascript:{}">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            @else
                <p>No Candidates have been registerd for this election</p>
            @endif
        @elseif($election->isClosed )
            <h4>Status: <span class="status-closed">Closed</span></h4>
            <h3>results</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>party</th>
                    <th>score</th>
                </tr>
                </thead>
                <tbody>
                @foreach($election->candidates as $candidate)
                    @if($candidate->pivot->approved)
                    <tr>
                        <td><a href="/backoffice/users/{{$candidate->user->id}}">{{$candidate->id}}</a></td>
                        <td><a href="/backoffice/users/{{$candidate->user->id}}">{{$candidate->user->firstname}} {{$candidate->user->lastname}}</a></td>
                        <td><a href="/backoffice/parties/{{$candidate->party->id}}">{{$candidate->party->name}}</a></td>
                        <td>{{$candidate->pivot->score}}</td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <h4>Statistics</h4>
            <div id="results-chart"></div>
        @else
            <h4>Status: <span class="status-open">Open</span></h4>
            <h3>Candidates</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>party</th>
                </tr>
                </thead>
                <tbody>
                @foreach($election->candidates as $candidate)
                    @if($candidate->pivot->approved)
                    <tr>
                        <td><a href="/backoffice/users/{{$candidate->user_id}}">{{$candidate->id}}</a></td>
                        <td><a href="/backoffice/users/{{$candidate->user_id}}">{{$candidate->user->firstname}} {{$candidate->user->lastname}}</a></td>
                        <td><a href="/backoffice/parties/{{$candidate->party->id}}">{{$candidate->party->name}}</a></td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        @endif

    </div>

    <div class="col-xs-12 col-sm-3 userInfo">
        <h3>info</h3>
        <div class="detail-page-head-image">
            <figure>
                <img src="{{$election->pictureUri}}" alt="election image">
            </figure>
        </div>
        <table class="table">
            <tbody>
            <tr>
                <th>name</th>
                <td>{{$election->name}}</td>
            </tr>
            <tr>
                <th>description</th>
                <td>{{$election->description}}</td>
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
                <td>{{$election->startDate}}</td>
            </tr>
            <tr>
                <th>ends on</th>
                <td>{{$election->endDate}}</td>
            </tr>
            <tr>
                <th>time left</th>
                {{--TODO: Countdown--}}
                <td></td>
            </tr>

            </tbody>
        </table>
        <form action="{{ URL::route('elections.destroy',$election->id) }}" method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <a class="btn btn-default" href="/backoffice/elections/{{$election->id}}/edit">Edit</a>
            <button onclick="return confirm('Are you sure you want to delete this election')" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection
@section('scripts')
<script>
    var $candidates = [
            @foreach ($election->candidates as $candidate)
            @if($candidate->pivot->approved)
            {
                firstname: "{{ $candidate->user->firstname }}" + " " + "{{ $candidate->user->lastname }}",
                lastname: "",
                score: "{{$candidate->pivot->score}}"
            },
            @endif
        @endforeach
    ];

    Morris.Bar({
        element: 'results-chart',
        data: $candidates,
        xkey: 'firstname',
        ykeys: ['score'],
        labels: ['Score']
    });
</script>
@endsection