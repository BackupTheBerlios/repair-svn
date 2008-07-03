//we willen een rij bewerken
function bewerkVeld(a){
	//de tekst veldjes omvormen
	$("#item_"+a).find(".edit").each(function(el) { 
		var input = "<td class='edit'><input class='restore' type='hidden' value='"+$(this).text()+"'/><input class='waarde' type='text' value='"+$(this).text()+"'/></td>"
		$(this).after(input).remove();
	});
	//categorie aanpassen
	$.post("ajax/postPersoneelAdmin.php", { "actie":"categorie", "locatie": "kot"},
				function (data){
					var cel = $("#item_"+a).find(".cat");
					var select = "<td class='cat'><input class='restore' type='hidden' value='"+cel.text()+"'/><select class='sel'>";
					for(prop in data){
						select += "<option value='"+prop+"'";
						if(data[prop]==cel.text())
							select += " selected='yes'";
						select += ">"+data[prop]+"</option>";
					}
					select += "</select></td>";
					cel.after(select).remove();
				},"json");	
	//eerste knop aanpassen
	var img1 = $("#item_"+a).find(".img").find(".bewerk");
	img1.each(function(){this.onclick = function(){submit(a)};});//event
	img1.attr("src", "images/icon_accept.gif");
	img1.attr("title", "Doorsturen");
	//tweede knop aanpassen
	var img2 = $("#item_"+a).find(".img").find(".verwijder");
	img2.each(function(){this.onclick = function(){restore(a)};});//event
	img2.attr("src", "images/action_stop.gif");
	img2.attr("title", "Annuleren");
}

function verwijderVeld(a){
	$("#item_"+a).addClass("deleted");
}

//we willen de rij herstellen
function restore(a){
	//waarden herstellen
	$("#item_"+a).find(".edit").each(function(el) { 
		var input = "<td class='edit'>"+$(this).find(".restore").attr('value')+"</td>";
		$(this).after(input).remove();
	});
	//categorie herstellen
	var cat = $("#item_"+a).find(".cat");
	var input = "<td class='cat'>"+cat.find(".restore").attr('value')+"</td>";
	cat.after(input).remove();
	//eerste knop herstellen
	var img1 = $("#item_"+a).find(".img").find(".bewerk");
	img1.each(function(){this.onclick = function(){bewerkVeld(a)};});//event
	img1.attr("src", "images/page_edit.gif");
	img1.attr("title", "Dit veld bewerken");
	//tweede knop herstellen
	var img2 = $("#item_"+a).find(".img").find(".verwijder");
	img2.each(function(){this.onclick = function(){verwijderVeld(a)};});//event
	img2.attr("src", "images/page_delete.gif");
	img2.attr("title", "Dit veld verwijderen");
}
//we willen de rij opslaan
function submit(a){
	var naam = new Array();
	$("#item_"+a).find(".edit").each(function(el) { naam[naam.length] = $(this).find(".waarde").attr('value');});
	var categorie = $("#item_"+a).find(".cat").find(".sel").attr('value');
	$.post("ajax/postPersoneelAdmin.php", { "actie":"edit", "id": a, "naam_NL": naam[0] ,"naam_EN": naam[1], "categorie_id":categorie},
				function (data){
					//alert(data);
				});	
	//terug de aanpassingen weg doen
	$("#item_"+a).find(".edit").each(function(el) { 
		var input = "<td class='edit'>"+$(this).find(".waarde").attr('value')+"</td>";
		$(this).after(input).remove();
	});
	//categorie terug zetten
	var cat = $("#item_"+a).find(".cat");
	var input = "<td class='cat'>"+cat.find(".sel option:selected").text()+"</td>";
	cat.after(input).remove();
	//eerste knop herstellen
	var img1 = $("#item_"+a).find(".img").find(".bewerk");
	img1.each(function(){this.onclick = function(){bewerkVeld(a)};});//event
	img1.attr("src", "images/page_edit.gif");
	img1.attr("title", "Dit veld bewerken");
	//tweede knop herstellen
	var img2 = $("#item_"+a).find(".img").find(".verwijder");
	img2.each(function(){this.onclick = function(){verwijderVeld(a)};});//event
	img2.attr("src", "images/page_delete.gif");
	img2.attr("title", "Dit veld verwijderen");
}