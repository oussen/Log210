@extends('layouts.master')

@section('title', 'Ajout de Livres')
@section('css')
    {!! Html::style('css/ajoutDeLivres.css') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="form-group col-md-3">
            <h1 id="title">Ajout de livre</h1>
            <div class="input-group">
                <input class="form-control" type="text" id="isbnText" placeholder="ISBN...">
                <span class="input-group-btn">
                    <button class="form-control" id="isbnSearch">ISBN</button>
                    <button class="form-control" id="upcSearch">UPC</button>
                    <button class="form-control" id="eanSearch">EAN</button>
                </span>
            </div>
        </div>
    </div>
@endsection