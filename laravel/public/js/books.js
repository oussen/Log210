/**
 * Created by victor on 10/20/15.
 */
$(document).ready(function() {
	$("button").click(function(){
	
		var titre = document.getElementById('title').innerHTML;
		var isbn =  document.getElementById('isbn').innerHTML;
		var auteurs = document.getElementById('authors').innerHTML;
		var pageCount = document.getElementById('pageCount').innerHTML;
		var prix = document.getElementById('price').innerHTML;
		
		var query = "INSERT INTO livres VALUES (" + isbn + ", " + titre + ", " + auteurs + ", " + pageCount + ", " + prix + ");"
		console.log(query);
		
		window.location.href = "ajoutDeLivres?query=" + query;
		
		document.getElementById("sqlQuery").innerHTML = query;
	});
});

