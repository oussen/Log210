@extends('layouts.master')

@section('title', 'Ajout de Livres')

@section('showName')
    <p class="navbar-text navbar-right">Bienvenue {{$user}}</p>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="form-group col-md-4">
            <h1 id="title">Ajout de livre</h1>
            <div class="input-group">
                <input class="form-control" type="text" id="isbnText" placeholder="ISBN...">
                <span class="input-group-btn">
                    <button class="form-control" id="isbnSearch" style="display:inline-block !important">ISBN</button>
                </span>
                <span class="input-group-btn">
                    <button class="form-control" id="upcSearch" style="display:inline-block !important">UPC</button>
                </span>
                <span class="input-group-btn">
                    <button class="form-control" id="eanSearch" style="display:inline-block !important">EAN</button>
                </span>
            </div>
        </div>

        <div id="returnBook" class="container-fluid well" style="background-color: #C2C2C2 !important; color: #333333 !important; display: none !important;">

        </div>
    </div>
@endsection