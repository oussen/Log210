@extends('layouts.master')

@section('title', 'Ajout de Livres')

@section('content')
    <div class="container-fluid">
        <h1 id="authTitle">ÒAJOUT'DE'LIVREÓ</h1>
        <div class="form-group">
            <form class="col-md-offset-3 col-md-6" style="padding-top: 3%; padding-bottom: 1%" method="post" action="{{ route('upcSearch') }}" accept-charset="UTF-8" id="submitForm">
                <div class="input-group">
                    <input class="form-control" type="text" id="isbnText" name="isbnText" placeholder="ISBN...">
                    <span class="input-group-btn">
                        <button class="form-control" id="isbnSearch" style="display:inline-block !important">ISBN</button>
                    </span>
                    <span class="input-group-btn">
                        <button class="form-control" id="upcSearch" style="display:inline-block !important">UPC</button>
                    </span>
                    <span class="input-group-btn">
                        <button class="form-control" id="eanSearch" style="display:inline-block !important">EAN</button>
                    </span>
                    <span class="input-group-btn">
                        <button class="form-control" id="btnSearch" style="display:inline-block !important">Search <span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                </form>

        </div>
    </div>
    <div id="returnBook" class="container-fluid well" style="box-shadow: none !important;">
        <?php
            if(isset($jsonUPC)){ ?>
                <div class="panel panel-default">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr><th>UPC</th><th>Titre</th><th>Auteur</th><th>Pages</th><th>Prix</th><th>Condition</th></tr>
                        </thead>
                        <tbody>
                        <tr><td id="isbn"><?php if(isset($jsonUPC['number'])){ echo $jsonUPC['number']; }?></td>
                            <td id="bookTitle" contenteditable="true"><?php if(isset($jsonUPC['itemname'])) { echo $jsonUPC['itemname']; } ?></td>
                            <td id="author" contenteditable="true"></td>
                            <td id="pageCount" contenteditable="true"></td>
                            <td id="price" contenteditable="true"><?php if(isset($jsonUPC['avg_price'])) { echo $jsonUPC['avg_price']; } ?></td>
                            <td contenteditable="true" class="select">
                                <select id="bookState">
                                    <option value="new">Comme Neuf</option>
                                    <option value="used">Usé</option>
                                    <option value="old">Très Usé</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <button class="form-control col-md-offset-5" id="saveBtn" name="upcBtn">Enregistrer</button>
            <?php
            } elseif (isset($jsonISBN)){ ?>
            <div class="panel panel-default">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr><th>ISBN</th><th>Titre</th><th>Auteur</th><th>Pages</th><th>Prix</th><th>Condition</th></tr>
                    </thead>
                    <tbody>
                    <tr><td id="isbn"><?php if (isset($jsonISBN['items'][0]['volumeInfo']['industryIdentifiers'][0]['identifier'])) { echo $jsonISBN['items'][0]['volumeInfo']['industryIdentifiers'][1]['identifier']; } ?></td>
                        <td id="bookTitle" contenteditable="true"><?php if (isset($jsonISBN['items'][0]['volumeInfo']['title'])) { echo $jsonISBN['items'][0]['volumeInfo']['title']; } ?></td>
                        <td id="author" contenteditable="true"><?php if(isset($jsonISBN['items'][0]['volumeInfo']['authors'][0])){ echo $jsonISBN['items'][0]['volumeInfo']['authors'][0]; } ?></td>
                        <td id="pageCount" contenteditable="true"><?php if(isset($jsonISBN['items'][0]['volumeInfo']['pageCount'])){ echo $jsonISBN['items'][0]['volumeInfo']['pageCount']; } ?></td>
                        <td id="price" contenteditable="true"><?php if(isset($jsonISBN['items'][0]['volumeInfo']['retailPrice']['amount'])){ echo $jsonISBN['items'][0]['volumeInfo']['retailPrice']['amount']; } ?></td>
                        <td id="bookState" contenteditable="true" class="select">
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
            <button class="form-control col-md-offset-5" id="saveBtn" name="isbnBtn">Enregistrer</button>
            <?php
            } elseif (isset($jsonEAN)){ ?>
            <div class="panel panel-default">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr><th>ISBN</th><th>Titre</th><th>Auteur</th><th>Pages</th><th>Prix</th><th>Condition</th></tr>
                    </thead>
                    <tbody>
                    <tr><td id="isbn"><?php if(isset($jsonEAN['gtin'])){ echo $jsonEAN['gtin']; } ?></td>
                        <td id="bookTitle" contenteditable="true"><?php if (isset($jsonEAN['name'])) { echo $jsonEAN['name']; } ?></td>
                        <td id="author" contenteditable="true"></td>
                        <td id="pageCount" contenteditable="true"></td>
                        <td id="price" contenteditable="true"></td>
                        <td id="bookState" contenteditable="true" class="select">
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
            <button class="form-control col-md-offset-5" id="saveBtn" name="eanBtn">Enregistrer</button>
            <?php
            } elseif (isset($dataDB)){ ?>
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
										}									
								?>
					</th><th>Titre</th><th>Auteur</th><th>Pages</th><th>Prix</th><th>Condition</th></tr>
                    </thead>
                    <tbody>
                    <tr><td id="isbn"><?php if(isset($dataDB->codeISBN)){
											echo $dataDB->codeISBN; 
										} 
										elseif(isset($dataDB->codeUPC)){
											echo $dataDB->codeUPC;
										}
										elseif(isset($dataDB->codeEAN))
										{
											echo $dataDB->codeEAN;
										}									
								?>
						</td>
                        <td id="bookTitle" contenteditable="true"><?php echo $dataDB->titre; ?></td>
                        <td id="author" contenteditable="true"><?php echo $dataDB->auteur; ?></td>
                        <td id="pageCount" contenteditable="true"><?php echo $dataDB->nombrePages; ?></td>
                        <td id="price" contenteditable="true"><?php echo $dataDB->prix; ?></td>
                        <td id="bookState" contenteditable="true" class="select">
                            <select>
                                <option value="new" <?php if($dataDB->condition == "new"){echo 'selected="true"';}?>>Comme Neuf</option>
                                <option value="used" <?php if($dataDB->condition == "used"){echo 'selected="true"';}?>>Usé</option>
                                <option value="old" <?php if($dataDB->condition == "old"){echo 'selected="true"';}?>>Très Usé</option>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <button class="form-control col-md-offset-5" id="saveBtn" name="eanBtn">Enregistrer</button>
            <?php
            }
        ?>
    </div>
@endsection