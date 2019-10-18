@extends('layouts.app')
@section('content')
    <div id="login" class="container">
        <figure id="logo">
            <img src="{{ asset('images/logo-square.svg') }}">
        </figure>
        <div id="formfield">
            <div class="form-field">
                <form role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-item">
                        <label>Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required
                               autofocus>
                    </div>
                    <div class="form-item">
                        <label>Wachtwoord</label>
                        <input id="password" type="password" class="form-control" name="password">
                    </div>
                    <div class="form-item">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="button-field">
                            <button type="submit" class="btn green">
                                Login
                            </button>
                            <a href="{{ route('register') }}" class="btn white borderless-btn">Registreer</a>
                        </div>
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block error">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    @if ($errors->has('password'))
                        <span class="help-block error">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
