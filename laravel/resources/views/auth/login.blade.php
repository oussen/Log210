<!-- resources/views/auth/login.blade.php -->
@extends('layouts.master')

@section('title', 'Login')

@section('scripts')
    {!! Html::script('js/login.js') !!}
@endsection

@section('content')
    <div class="container col-md-4 col-md-offset-4">
        <h1 id="authTitle">ÒLOGINÓ</h1>
        <form method="POST" action="/auth/login" style="padding-top: 10%">
            {!! csrf_field() !!}

            <div>
                Email/Phone Number
                <input class="form-control" type="text" name="login" value="{{ old('email') }}">
            </div>

            <div id="authDiv">
                Password
                <input class="form-control" type="password" name="password" id="password">
            </div>

            <div id="authDiv">
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <div id="authDiv">
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