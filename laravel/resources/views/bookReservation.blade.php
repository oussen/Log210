@extends('layouts.master')

@section('title', 'Réservation')

@section('scripts')
    {!! Html::script('js/reservation.js', array(), true) !!}
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

    @if(isset($confirmationEmailDone))
        <div class="alert alert-success" role="alert" style="text-align: center">Vous recevrez un email quand votre livre sera disponible.</div>
    @endif

    <div id="returnBook" class="container-fluid well" style="box-shadow: none !important; margin-top: 2%">
        <?php
        if(isset($emptyData)){
            if($emptyData == 'false'){ ?>
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
                <tr><td id="isbn-{{$livre->id}}"><?php if(isset($livre->codeISBN)){
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
                    <td id="bookTitle-{{$livre->id}}"><?php if(isset($livre->titre)){echo $livre->titre; }?></td>
                    <td id="author-{{$livre->id}}"><?php if(isset($livre->auteur)){echo $livre->auteur; }?></td>
                    <td id="pageCount-{{$livre->id}}"><?php if(isset($livre->nombrePages)){echo $livre->nombrePages; }?></td>
                    <td id="price-{{$livre->id}}"><?php if(isset($livre->prix)){echo $livre->prix; }?></td>
                    <td id="bookState-{{$livre->id}}">@if(isset($livre->condition))
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
                    <td id="deliveryPrice-{{$livre->id}}" style="@if($livre->idCOOP != Auth::user()->idCOOP) color:red !important @endif" >
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
            <input type="hidden" id="currentBookCoopID" value="<?php echo $livre->idCOOP ?>"/>
        </div>
        <button class="form-control col-md-offset-5" id="saveReservationBtn" name="saveReservationBtn">Enregistrer</button>
    <?php
    } else { ?>
        <div class="alert alert-danger alert-dismissible" role="alert" style="text-align: center">Oops! Nous avons rien trouvé... Veuillez entrer le <b>numéro ISBN</b> du livre que vous désirez acheter et vous serez notifié par courriel quand il sera disponible.</div>
        <form class="col-md-offset-4 col-md-4" style="padding-top: 3%; padding-bottom: 1%" method="post" action="{{ route('isbnSearch') }}" accept-charset="UTF-8" id="submitForm">
            <div class="input-group">
                <input class="form-control" type="text" id="isbnText" name="isbnText" placeholder="ISBN...">
                <span class="input-group-btn">
                    <button class="form-control" id="isbnSearch" style="display:inline-block !important; border-top-right-radius: 4px !important; border-bottom-right-radius: 4px !important">ISBN</button>
                </span>
            </div>
            <input name="pageName" type="hidden" value="bookReservation"/>
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        </form>
            @if(isset($jsonISBN))
                <form method="post" action="{{ route('reservationEmail') }}" accept-charset="UTF-8" id="confirmationEmailForm">
                    <div class="panel panel-default">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr><th>ISBN</th><th>Titre</th><th>Auteur</th><th>Pages</th><th>Prix</th><th>Condition</th></tr>
                            </thead>
                            <tbody>
                            <tr><td id="isbn"><?php if (isset($jsonISBN['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'])) { echo $jsonISBN['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier']; } ?></td>
                                <td id="bookTitle"><?php if (isset($jsonISBN['items'][0]['volumeInfo']['title'])) { echo $jsonISBN['items'][0]['volumeInfo']['title']; } ?></td>
                                <td id="author"><?php if(isset($jsonISBN['items'][0]['volumeInfo']['authors'][0])){ echo $jsonISBN['items'][0]['volumeInfo']['authors'][0]; } ?></td>
                                <td id="pageCount"><?php if(isset($jsonISBN['items'][0]['volumeInfo']['pageCount'])){ echo $jsonISBN['items'][0]['volumeInfo']['pageCount']; } ?></td>
                                <td id="price"><?php if(isset($jsonISBN['items'][0]['volumeInfo']['retailPrice']['amount'])){ echo $jsonISBN['items'][0]['volumeInfo']['retailPrice']['amount']; } ?></td>
                                <td id="bookState" class="select">
                                    <select>
                                        <option value="new">Comme Neuf</option>
                                        <option value="used">Usé</option>
                                        <option value="old">Très Usé</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-warning" role="alert" style="text-align: center">Si c'est bien le livre que vous voulez, confirmer votre choix.</div>
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input name="userID" type="hidden" value="{{Auth::user()->id}}"/>
                    <input name="isbnNumber" type="hidden" value="<?php if (isset($jsonISBN['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'])) { echo $jsonISBN['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier']; } ?>"/>

                    <button class="form-control col-md-offset-5" id="confirmationEmailBtn">Confirmer</button>
                </form>
            @endif

    <?php }}?>

            @if (!isset($xmlEBay))
                <form method="post" action="{{ route('sellEbay') }}" accept-charset="UTF-8" id="formSellEbay">
                    <input type="hidden" name="titleBook" value="Title">
                    <input type="hidden" name="priceBook" value="0">
                    <input type="image" src="ebay.png" name="submit" style="width: 100px; height: 40px;" alt="Submit">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                </form>
            @else
                <div class="alert alert-success" role="alert" style="text-align: center">Votre item a été placé sur eBay avec succés!</div>
            @endif
    </div>
@endsection

