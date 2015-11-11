@extends('layouts.master')

@section('title', 'Réservation')

@section('scripts')
    {!! Html::script('js/reservation.js') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <h1 id="authTitle">ÒRESERVATION'DE'LIVRESÓ</h1>
        <div class="col-md-4 col-md-offset-4">
            <form method="post" action="{{ route('findBooksForReservation') }}" accept-charset="UTF-8" id="submitForm">
                <div>
                    <div>
                        <input class="form-control" type="text" id="isbnText" name="isbnText" placeholder="ISBN, UPC, EAN...">
                    </div>
                    <div id="authDiv">
                        <input class="form-control" type="text" name="titreText" id="titreText" placeholder="Titre du livre...">
                    </div>
                    <div id="authDiv">
                        <input class="form-control" type="text" id="authorName" name="authorName" placeholder="Nom de l'auteur...">
                    </div>
                    <div id="authDiv">
                        <input type="hidden" name="userCoopID" value="{{Auth::user()->idCOOP}}"/>
                        <input class="form-control" type="submit" id="btnSearch" value="Search">
                    </div>
                </div>
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            </form>
        </div>
    </div>

    <div id="returnBook" class="container-fluid well" style="box-shadow: none !important; margin-top: 2%">
        <?php
        if(!empty($dataDB)) {?>
        <div class="panel panel-default">
            <table class="table table-striped table-bordered">
                <thead>
                <tr><th><?php if(isset($dataDB->codeISBN)){
                            echo "ISBN";
                        }
                        elseif(isset($dataDB->codeUPC)){
                            echo "UPC";
                        }
                        elseif(isset($dataDB->codeEAN))
                        {
                            echo "EAN";
                        } else {
                            echo "ISBN/UPC/EAN";

                        }
                        ?>
                    </th><th>Titre</th><th>Auteur</th><th>Pages</th><th>Prix</th><th>Condition</th><th>Selectionner</th><th>Livraison</th></tr>
                </thead>
                <tbody>
                <?php foreach($dataDB as $livre){ ?>
                <tr><td id="isbn"><?php if(isset($livre->codeISBN)){
                            echo $livre->codeISBN;
                        }
                        elseif(isset($livre->codeUPC)){
                            echo $livre->codeUPC;
                        }
                        elseif(isset($livre->codeEAN))
                        {
                            echo $livre->codeEAN;
                        }
                        ?>
                    </td>
                    <td id="bookTitle"><?php if(isset($livre->titre)){echo $livre->titre; }?></td>
                    <td id="author"><?php if(isset($livre->auteur)){echo $livre->auteur; }?></td>
                    <td id="pageCount"><?php if(isset($livre->nombrePages)){echo $livre->nombrePages; }?></td>
                    <td id="price"><?php if(isset($livre->prix)){echo $livre->prix; }?></td>
                    <td id="bookState">@if(isset($livre->condition))
                                           @if($livre->condition == "new")
                                               Comme Neuf
                                           @elseif($livre->condition == "used")
                                               Usé
                                           @else
                                               Très Usé
                                           @endif
                                      @endif
                    </td>
                    <td id="selected" align="center"><input type="checkbox" id="chkSelect-<?php echo $livre->id; ?>"></td>
                    <td id="{{$livre->id}}-deliveryPrice" style="@if($livre->idCOOP != Auth::user()->idCOOP) color:red !important @endif" >
                        @if($livre->idCOOP != Auth::user()->idCOOP)
                            10$
                        @else
                            Aucune
                        @endif
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <input type="hidden" id="reservedUntil" value="<?php echo strtotime('+2 day', time()) ?>"/>
            <input type="hidden" id="currentUserID" value="{{Auth::user()->id}}"/>
        </div>
        <button class="form-control col-md-offset-5" id="saveReservationBtn" name="saveReservationBtn">Enregistrer</button>
    <?php
    }?>

    </div>
@endsection
@endsection

