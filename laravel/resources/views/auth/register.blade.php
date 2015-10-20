<!-- resources/views/auth/register.blade.php -->
@extends('layouts.master')

@section('title', 'Enregistrement')

@section('content')
    <h1 class="col-xs-offset-1"> Register </h1>
    <div class="container col-xs-4 col-md-offset-4">
        <form method="POST" action="/auth/register">
            {!! csrf_field() !!}

            <div>
                Name
                <input class="form-control" type="text" name="name" value="{{ old('name') }}">
            </div>

            <div>
                Email
                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
            </div>

            <div>
                Phone
                <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
            </div>

            <div>
                Password
                <input class="form-control" type="password" name="password">
            </div>

            <div>
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