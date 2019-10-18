@extends('master')
@section('title')
    Create new election
{{--    {{ ucfirst(trans($election->name))}}--}}

@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/backoffice/elections">Elections</a></li>
        <li class="active" ><a href="/backoffice/elections/{{$election->id}}">{{$election->name}}</a></li>
        <li class="active" >edit</li>
    </ol>
@endsection
@section('content')
    <div class="col-xs-12 col-sm-9">
        <form action="{{action('ElectionController@update',['id'=>$election->id])}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PATCH">
            {{csrf_field()}}
            <div class="form-group">
                <label for="title">name</label>
                <input value="{{$election->name}}" type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="group">Group</label>
                <select id="group" name="group" class="form-control">
                    @foreach($groups as $group2)
                        @if($group2->id === $group->id)
                            <option selected value="{{$group2->id}}">{{$group2->name}}</option>
                        @else
                            <option value="{{$group2->id}}">{{$group2->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="form-group col-xs-6">
                    <label for="startDate">Start time</label>
                    <div class="row">
                        <div class="col-xs-6">
                            <input value="{{date("Y-m-d", strtotime($election->startDate))}}" type="date" class="form-control col-xs-5" id="startDate" name="startDate">
                        </div>
                        <div class="col-xs-6">
                            <input value="{{date("H:i", strtotime($election->startDate))}}" type="time" class="form-control col-xs-5" id="startTime" name="startTime">
                        </div>
                    </div>
                </div>
                <div class="form-group col-xs-6">
                    <label for="endDate">End time</label>
                    <div class="row">
                        <div class="col-xs-6">
                            <input value="{{date("Y-m-d", strtotime($election->endDate))}}" type="date" class="form-control col-xs-5" id="endDate" name="endDate">
                        </div>

                        <div class="col-xs-6">
                            <input value="{{date("H:i", strtotime($election->endDate))}}" type="time" class="form-control col-xs-5" id="endTime" name="endTime">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description">{{$election->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="imgUpload">Image</label>
                <input type="file" class="form-control" id="imgUpload" name="imgUpload" accept="image/*"/>
            </div>
            {{--<div class="form-group">--}}
                {{--<div class="checkbox">--}}
                    {{--@if($election->published!= false)--}}
                        {{--<label><input type="checkbox" id="published" name="published" checked>published</label>--}}
                    {{--@else--}}
                        {{--<label><input type="checkbox" id="published" name="published">published</label>--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="form-group">
                <button type="submit" class="btn btn-primary">edit</button>
                <button type="reset"  class="btn btn-danger">reset</button>
            </div>
        </form>
    </div>
    <div class="col-xs-12 col-sm-3 errors">
        @include('partials.error')
    </div>
@endsection