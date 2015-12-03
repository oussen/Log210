@extends('layouts.master')

@section('title', 'Livraison')

@section('scripts')
    {!! Html::script('js/bookDelivery.js', array(), true) !!}
@endsection

@section('content')
    <h1 id="authTitle">ÒLIVRAISONÓ</h1>
    <div id="reservedBooks" class="container-fluid well" style="box-shadow: none !important; margin-top: 2%">
        <form method="post" action="{{ route('acceptDelivery') }}" accept-charset="UTF-8" id="deliveryForm">
            <div class="panel panel-default">
                @if(isset($delivery))
                    @if($delivery == "success")
                        <div class="alert alert-success" role="alert" id="success-alert">L'achat a été complété avec succès!</div>
                    @elseif($delivery == "failure")
                        <div class="alert alert-danger" role="alert" id="danger-alert">L'achat a été annulé avec succès!</div>
                    @endif
                @endif
                <table class="table table-striped table-bordered" id="table">
                    <thead>
                        <tr><th>ISBN/UPC/EAN</th><th>Titre</th><th>Auteur</th><th>Pages</th><th>Prix</th><th>Condition</th><th>Selectionner</th><th>Livraison</th></tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($dataDB)){ foreach($dataDB as $livre){ ?>
                    <tr><td id="isbn-{{ $livre[0]->id }}"><?php if(isset($livre[0]->codeISBN)){
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
                        <td id="bookTitle-{{ $livre[0]->id }}"><?php if(isset($livre[0]->titre)){echo $livre[0]->titre; }?></td>
                        <td id="author-{{ $livre[0]->id }}"><?php if(isset($livre[0]->auteur)){echo $livre[0]->auteur; }?></td>
                        <td id="pageCount-{{ $livre[0]->id }}"><?php if(isset($livre[0]->nombrePages)){echo $livre[0]->nombrePages; }?></td>
                        <td id="price-{{ $livre[0]->id }}"><?php if(isset($livre[0]->prix)){echo $livre[0]->prix; }?></td>
                        <td id="bookState-{{ $livre[0]->id }}">@if(isset($livre[0]->condition))
                                @if($livre[0]->condition == "new")
                                    Comme Neuf
                                @elseif($livre[0]->condition == "used")
                                    Usé
                                @else
                                    Très Usé
                                @endif
                            @endif
                        </td>
                        <td id="selected" align="center"><input type="checkbox" id="chkSelect-{{ $livre[0]->id }}"></td>
                        <td id="deliveryPrice-{{$livre[0]->id}}" style="@if($livre[0]->idCOOP != Auth::user()->idCOOP) color:red !important @endif" >
                            @if($livre[0]->idCOOP != Auth::user()->idCOOP)
                                10$
                            @else
                                Aucune
                            @endif
                        </td>
                    </tr>
                    <input type="hidden" name="bookID" value="{{ $livre[0]->id }}"/>
                    <input type="hidden" name="userID" value="{{ $askingUserID }}"/>
                    <?php } }?>
                    </tbody>
                </table>
            </div>
            <input type="hidden" name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <div class="row">
                <div class="col-md-4 col-md-offset-4" style="padding-left: 8%">
                    <button class="form-control btn btn-success btn-block" id="acceptDelivery" style="width: 200px">Accepter</button>
                    <button class="form-control btn btn-danger btn-block" id="declineDelivery" style="width: 200px">Refuser</button>
                </div>
            </div>
        </form>

        <form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post' name='formPaypal'>
            <input type='hidden' name='business' value='testingpaypal123@gmail.com'>
            <input type='hidden' name='cmd' value='_xclick'>
            <input type='hidden' name='item_name' value='Test'>
            <input type='hidden' name='item_number' value='11111'>
            <input type='hidden' name='amount' value='10.23'>
            <input type='hidden' name='no_shipping' value='1'>
            <input type='hidden' name='currency_code' value='CAD'>
            <input type='hidden' name='cancel_return' value='{{ route('bookDelivery') }}'>
            <input type='hidden' name='return' value='{{ route('bookDelivery') }}'>
            <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" name="submit">
        </form>
    </div>
@endsection
