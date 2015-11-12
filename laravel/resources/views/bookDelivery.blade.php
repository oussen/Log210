@extends('layouts.master')

@section('title', 'Livraison')

@section('content')
    <div id="reservedBooks" class="container-fluid well" style="box-shadow: none !important; margin-top: 2%">
        <div class="panel panel-default">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr><th>ISBN/UPC/EAN</th><th>Titre</th><th>Auteur</th><th>Pages</th><th>Prix</th><th>Condition</th><th>Selectionner</th><th>Livraison</th></tr>
                </thead>
                <tbody>
                <?php foreach($dataDB as $livre){ ?>
                <tr><td id="isbn"><?php if(isset($livre[0]->codeISBN)){
                            echo $livre[0]->codeISBN;
                        }
                        elseif(isset($livre[0]->codeUPC)){
                            echo $livre[0]->codeUPC;
                        }
                        elseif(isset($livre[0]->codeEAN))
                        {
                            echo $livre[0]->codeEAN;
                        }
                        ?>
                    </td>
                    <td id="bookTitle"><?php if(isset($livre[0]->titre)){echo $livre[0]->titre; }?></td>
                    <td id="author"><?php if(isset($livre[0]->auteur)){echo $livre[0]->auteur; }?></td>
                    <td id="pageCount"><?php if(isset($livre[0]->nombrePages)){echo $livre[0]->nombrePages; }?></td>
                    <td id="price"><?php if(isset($livre[0]->prix)){echo $livre[0]->prix; }?></td>
                    <td id="bookState">@if(isset($livre[0]->condition))
                            @if($livre[0]->condition == "new")
                                Comme Neuf
                            @elseif($livre[0]->condition == "used")
                                Usé
                            @else
                                Très Usé
                            @endif
                        @endif
                    </td>
                    <td id="selected" align="center"><input type="checkbox" id="chkSelect-<?php echo $livre[0]->id; ?>"></td>
                    <td id="{{$livre[0]->id}}-deliveryPrice" style="@if($livre[0]->idCOOP != Auth::user()->idCOOP) color:red !important @endif" >
                        @if($livre[0]->idCOOP != Auth::user()->idCOOP)
                            10$
                        @else
                            Aucune
                        @endif
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <button class="form-control col-md-offset-5" id="saveReservationBtn" name="saveReservationBtn">Enregistrer</button>
    </div>
@endsection
