@extends('layouts.app')

@section('content')
    <div id="login" class="container">
        <figure id="logo">
            <img src="{{ asset('images/logo-square.svg') }}">
        </figure>
        <div id="formfield">
            <div class="form-field">
                <form>
                    <h1>Helaas uw stem is ongeldig!</h1>
                    <a href="/">Terug</a>
                </form>
            </div>
        </div>
    </div>
@endsection
