@extends('layouts.master')

@section('title', 'Reception')

@section('scripts')
    {!! Html::script('js/receptionLivre.js') !!}
@endsection

@section('content')
    <div class="container-fluid">
        <h1 id="authTitle">ÒRECEPTION'DE'LIVRESÓ</h1>
        <div class="col-md-4 col-md-offset-4">
           <form method="post" action="{{ route('rechercheLivre') }}" accept-charset="UTF-8" id="submitForm">
               <div>
                   <div>
                       <input class="form-control" type="text" id="isbnText" name="isbnText" placeholder="ISBN, UPC, EAN...">
                   </div>
                   <div id="authDiv">
                       <input class="form-control" type="text" name="titreText" id="titreText" placeholder="Titre du livre...">
                   </div>
                   <div id="authDiv">
                       <input class="form-control" type="text" id="studentName" name="studentName" placeholder="Nom de l'étudiant...">
                   </div>
                   <div id="authDiv">
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
                    </th><th>Titre</th><th>Auteur</th><th>Pages</th><th>Prix</th><th>Condition</th><th>Selectionner</th></tr>
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
                    <td id="bookTitle" contenteditable="true"><?php if(isset($livre->titre)){echo $livre->titre; }?></td>
                    <td id="author" contenteditable="true"><?php if(isset($livre->auteur)){echo $livre->auteur; }?></td>
                    <td id="pageCount" contenteditable="true"><?php if(isset($livre->nombrePages)){echo $livre->nombrePages; }?></td>
                    <td id="price" contenteditable="true"><?php if(isset($livre->prix)){echo $livre->prix; }?></td>
                    <td id="bookState" contenteditable="true" class="select">
                        <select>
                            <option value="new" <?php if(isset($livre->condition)){if($livre->condition == "new"){echo 'selected="true"';}}?>>Comme Neuf</option>
                            <option value="used" <?php if(isset($livre->condition)){if($livre->condition == "used"){echo 'selected="true"';}}?>>Usé</option>
                            <option value="old" <?php if(isset($livre->condition)){if($livre->condition == "old"){echo 'selected="true"';}}?>>Très Usé</option>
                        </select>
                    </td>
                    <td id="selected" align="center"><input type="checkbox" id="chkSelect<?php echo $livre->id; ?>"></td>
                </tr>
                <a href='mailto:<?php if(isset($livre->email)){echo $livre->email;} ?>?subject=Reception%20de%20livres&body=Votre%20livre%20a%20ete%20recu.' id='SendMail<?php if(isset($livre->id)){echo $livre->id;} ?>'></a>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <button class="form-control col-md-offset-5" id="saveBtnRec" name="eanBtn">Enregistrer</button>
        <?php
        }
        ?>
    </div>
@endsection