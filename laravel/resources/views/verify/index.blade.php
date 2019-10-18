
@extends('layouts.app')

@section('content')
    <div id="login" class="container">
        <figure id="logo">
            <img src="{{ asset('images/logo-square.svg') }}">
        </figure>
        <div id="formfield">
            <div class="form-field">
                <form  role="form" method="POST" action="{{ action('VerifyController@check') }}">
                    {{ csrf_field() }}
                    <div class="form-item">
                        <label for="uuid" >Stemcode:</label>
                        <input id="uuid" type="text" class="form-control" name="uuid" value="{{ old('uuid') }}" required autofocus>
                    </div>
                    <div class="form-item">
                        <label for="password" >Opgegeven wachtwoord:</label>
                        <input id="password" type="text" class="form-control" name="password" value="{{ old('password') }}" autofocus>
                    </div>
                    @if ($errors->has('uuid'))
                        <span class="help-block error">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <strong>{{ $errors->first('uuid') }}</strong>
                        </span>
                    @endif
                    @if ($errors->has('password'))
                        <span class="help-block error">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <div class="button-field">
                            <button type="submit" class="btn btn-primary">
                                Controleer stem
                            </button>
                        </div>
                    </div>
                    <a href="/">Terug</a>
                </form>
            </div>
        </div>
    </div>
@endsection