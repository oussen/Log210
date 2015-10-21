@extends('layouts.master')

@section('title', 'Ajout de Livres')

@section('content')
    <div id="rechercheISBN">
		<form action="ajoutDeLivres" method="GET">
		<input class="txtLivres" type="text" name="ISBN" placeholder="Code ISBN">
		<input type="submit">
		</form>
	</div>
	
	<?php
	
	if(isset($_GET['ISBN'])){
		if($_GET['ISBN'] != "")
		{
			$isbn = $_GET['ISBN'];
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL,"https://www.googleapis.com/books/v1/volumes?q=+isbn:". $isbn . "&key=AIzaSyBbtI1mN-lvCzHQrCxVel47M9IF4I9udL0&fields=items/volumeInfo(title,authors,pageCount),items/saleInfo/retailPrice/amount");
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
			
			$livre = json_decode($result, true);
			
			if(isset($livre['items'])){
				
				$titre = "";
				$auteurs = "";
				$pageCount = "";
				$prix = "";
				
				$info_livre = $livre['items'][0];
				curl_close($curl);
				
				if(isset($info_livre['volumeInfo']['title'])){
					$titre = $info_livre['volumeInfo']['title'];
				}
			
				if(isset($info_livre['volumeInfo']['authors'])){
					$auteurs = $info_livre['volumeInfo']['authors'][0];
				}
			
				if(isset($info_livre['volumeInfo']['pageCount'])){
					$pageCount = $info_livre['volumeInfo']['pageCount'];
				}
			
				if(isset($info_livre['volumeInfo']['retailPrice'])){
					$prix = $info_livre['volumeInfo']['retailPrice']['amount'];
				}
				
				echo 'Veuillez corriger toute imperfection dans les données recueillies.';
				
				echo '<table class="table">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>Titre</th>';
				echo '<th>Auteur</th>';
				echo '<th>Nombre de pages</th>';
				echo '<th>Prix</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				echo '<tr class="odd">';
				echo '<td id="title" contenteditable="true">' . $titre . '</td>';
				echo '<td id="authors" contenteditable="true">' . $auteurs . '</td>';
				echo '<td id="pageCount" contenteditable="true">' . $pageCount . '</td>';
				echo '<td id="price" contenteditable="true">' . $prix . '</td>';
				echo '</tr>';
				echo '</tbody>';
				echo '</table>';
				
				echo '<button type="button">Enregistrer</button>';
			}
			else
			{
				echo $result;
			}
		}
	}
	?>
	
@endsection

@section('scripts')
	{!! Html::script('js/books.js') !!}
@endsection