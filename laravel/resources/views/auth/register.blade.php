
@extends('layouts.app')
@section('content')
    <div id="register" class="container">
        <figure id="logo">
            <img src="{{ asset('images/logo-square.svg') }}">
        </figure>
        <div class="form-field">
            <form role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="form-item {{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="username">Username:</label>
                    <input id="username" type="text"  name="username" value="{{ old('username') }}" required autofocus>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-item{{ $errors->has('firstname') ? ' has-error' : '' }}">
                    <label for="username">First name:</label>
                    <input id="username" type="text"  name="firstname" value="{{ old('firstname') }}" required autofocus>
                    @if ($errors->has('firstname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-item{{ $errors->has('lastname') ? ' has-error' : '' }}">
                    <label for="username" >Last name</label>
                    <input id="username" type="text"  name="lastname" value="{{ old('lastname') }}" required autofocus>
                    @if ($errors->has('lastname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-item{{ $errors->has('gender') ? ' has-error' : '' }}">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required autofocus>
                        <option value="not applicable">Not applicable</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    @if ($errors->has('gender'))
                        <span class="help-block">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-item{{ $errors->has('birthdate') ? ' has-error' : '' }}">
                    <label for="birthdate" >Birthdate</label>
                    <input id="birthdate" type="date" name="birthdate" value="{{ old('birthdate') }}" placeholder="2011-03-11" required autofocus>
                    @if ($errors->has('birthdate'))
                        <span class="help-block">
                            <strong>{{ $errors->first('birthdate') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-item{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" >E-Mail Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-item{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-item">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="button-field">
                    <button type="submit" class="btn green">Register</button>
                </div>
            </form>
        </div>
    </div>
@endsection
