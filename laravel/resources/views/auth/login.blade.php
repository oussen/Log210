<!-- resources/views/auth/login.blade.php -->
@extends('layouts.master')

@section('title', 'Login')

@section('scripts')
    {!! Html::script('js/login.js') !!}
@endsection

@section('showName')
    <p class="navbar-text navbar-right">Not logged in</p>
@endsection

@section('content')
    <div class="container col-md-3 col-md-offset-4">
        <form method="POST" action="/auth/login">
            {!! csrf_field() !!}

            <div>
                Email/Phone Number
                <input class="form-control" type="text" name="login" value="{{ old('email') }}">
            </div>

            <div>
                Password
                <input class="form-control" type="password" name="password" id="password">
            </div>

            <div>
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <div>
                <button class="form-control" type="submit">Login</button>
                <input type="hidden" id="hiddenEmail" name="email" value="" />
                <input type="hidden" id="hiddenPhone" name="phone" value="" />
            </div>
            <div>
                Don't have an account? <a href="/auth/register">Register</a>
            </div>
        </form>
    </div>
@endsection