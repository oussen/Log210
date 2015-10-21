/**
 * Created by victor on 10/20/15.
 */
$(document).ready(function() {
	$("button").click(function(){
		var ISBN = document.getElementById("ISBN").innerHTML();
		$("td[contenteditable=true]").each(function(){
			if($(this).attr("id") == "title")
			{
				var titre = $(this).text();
			}
			else if($(this).attr("id") == "authors")
			{
				var auteurs = $(this).text();
			}
			else if($(this).attr("id") == "pageCount")
			{
				var pageCount = $(this).text();
			}
			else if($(this).attr("id") == "price")
			{
				var prix = $(this).text();
			}
		});
		
		var query = "INSERT INTO livres VALUES (" + ISBN + ", " + titre + ", " + auteurs + ", " + pageCount + ", " + prix + ");"
		console.log(query);
		
		document.getElementsByName("sqlQuery").innerHTML = query;
	});
});

