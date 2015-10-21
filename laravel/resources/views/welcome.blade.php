@extends('layouts.master')

@section('title', 'Acceuil')

@section('showName')
    <p class="navbar-text navbar-right">Bienvenue {{$user}}</p>
@endsection

@section('content')
    <p>Bienvenue a la page d'acceuil</p>
@endsection
