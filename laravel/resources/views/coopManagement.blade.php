@extends('layouts.master')

@section('title', 'Coop')

@section('scripts')
    {!! Html::script('js/coop.js', array(), true) !!}
@endsection

@section('content')
    <div class="container-fluid">
        <h1 id="authTitle">ÒCOOPERATIVESÓ</h1>

        <div class="col-md-offset-4 col-md-4">
            @if(Auth::user()->isManager == 1)
                {!! Form::open(array('route' => 'submitCoop')) !!}
                    <div>
                        Nom de la coopérative
                        <input type="text" id="coopName" name="coopName" class="form-control" placeholder="Nom de la coop...">
                    </div>
                    <div>
                        Addresse de la coopérative
                        <input type="text" id="coopAddress" name="coopAddress" class="form-control" placeholder="Adresse de la coop...">
                    </div>
                    <div>
                        <br>
                        <button class="form-control" type="submit">Enregistrer</button>
                    </div>
                {!! Form::close() !!}
            @else
                {!! Form::open(array('route' => 'joinCoop')) !!}
                    <select class="form-control" id="coopSelect">
                        <option value="" disabled selected>Choisir une coopérative</option>
                        @if(!empty($coop))
                            @foreach($coop as $data)
                                <option id="coopOption" value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <div>
                        <input type="hidden" name="coopSelected" id="coopSelected" value="null">
                        <br>
                        <button class="form-control" type="submit">Enregistrer</button>
                    </div>
                {!! Form::close() !!}
            @endif
        </div>
    </div>
@endsection
