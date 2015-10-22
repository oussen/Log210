<!-- resources/views/auth/register.blade.php -->
@extends('layouts.master')

@section('title', 'Enregistrement')

@section('content')
    <div class="container col-md-4 col-md-offset-4">
        <h1 id="authTitle"> ÒREGISTERÓ </h1>
        <form method="POST" action="/auth/register" style="padding-top: 10%">
            {!! csrf_field() !!}

            <div>
                Name
                <input class="form-control" type="text" name="name" value="{{ old('name') }}">
            </div>

            <div id="authDiv">
                Email
                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
            </div>

            <div id="authDiv">
                Phone
                <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
            </div>

            <div id="authDiv">
                Password
                <input class="form-control" type="password" name="password">
            </div>

            <div id="authDiv">
                Confirm Password
                <input class="form-control" type="password" name="password_confirmation">
            </div>

            <div>
                <br>
                <input type="checkbox" name="isManager" value="1"> Manager
            </div>

            <div>
                <br>
                <button class="form-control" type="submit">Register</button>
            </div>

            <div>
                Already have an account? <a href="/auth/login">Login</a>
            </div>
        </form>
    </div>
@endsection