@extends('master')
@section('title')
    Create new group
{{--    {{ ucfirst(trans($election->name))}}--}}

@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/backoffice/groups">Groups</a></li>
        <li class="active" >New</li>
    </ol>
@endsection
@section('content')
    <div class="col-xs-12 col-sm-9">
        <form method="POST" action="/backoffice/groups" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="imgUpload">Image</label>
                <input type="file" class="form-control" id="imgUpload" name="imgUpload" accept="image/*"/>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">submit</button>
            </div>
        </form>
    </div>
    <div class="col-xs-12 col-sm-3 errors">
        @include('partials.error')
    </div>
@endsection