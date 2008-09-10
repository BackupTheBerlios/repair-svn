$(document).ready(function(){
	$(".img1").each(setBewerk);//bewerkfunctionaliteit instellen
	$(".img2").each(setVerwijder);//verwijderfunctionaliteit instellen
	
	$(".img").each(setVoegtoe);
});

function bewerk(){
	var rij = $(this).parent().parent();
	
	//tekst velden omzetten
	rij.find(".edit").each(function(){
		var waarde = $(this).html();
		$(this).html("<input type='hidden' value='"+waarde+"'/><input type='text' value='"+waarde+"'/>");
	});
	
	rij.find(".img1").each(setOK);
	rij.find(".img2").each(setCancel);
}

function verwijder(){
	if(confirm("Bent u zeker dat u deze categorie wilt verwijderen?")){
		$.post("ajax/postPersoneelCategorie.php", { "actie":"remove", "id": $(this).parent().parent().attr("id").split("_")[0]});
		$(this).parent().html("").parent().addClass("deleted").find(".img1").html("");
	}
}

function OK(){
	var rij = $(this).parent().parent();
	var id = rij.attr("id").split("_")[0];
	var velden = new Array();
	var waarden = new Array();
	
	rij.find(".edit").each(function(){
		var waarde = $(this).find("input[@type=text]").val();
		velden[velden.length] = $(this).attr("id").split("_")[0];
		waarden[waarden.length] = waarde;
		$(this).html(waarde);
	});
	
	waarden = $.toJSON(waarden);
	velden = $.toJSON(velden);
	$.post("ajax/postPersoneelCategorie.php", { "actie":"edit", "id": id, "waarden": waarden ,"velden": velden});
	
	rij.find(".img1").each(setBewerk);
	rij.find(".img2").each(setVerwijder);
}

function cancel(){
	var rij = $(this).parent().parent();
	
	//tekst herstellen	
	rij.find(".edit").each(function(){
		$(this).html($(this).find("input[@type=hidden]").val());
	});
	
	rij.find(".img1").each(setBewerk);
	rij.find(".img2").each(setVerwijder);
}

function voegtoe(){
	var rij = $(this).parent().parent();
	var velden = new Array();
	var waarden = new Array();
	var r = "<tr><td></td>";
	
	rij.find(".edit").each(function(){
		var waarde = $(this).find("input[@type=text]").val();
		velden[velden.length] = $(this).attr("id").split("_")[0];
		waarden[waarden.length] = waarde;
		$(this).find("input[@type=text]").val("");
		r += "<td>"+waarde+"</td>";
	});
	r += "<td></td><td></td></tr>";
	rij.before(r);
	velden[velden.length] = "locatie";
	waarden[waarden.length] = rij.attr("id");
	waarden = $.toJSON(waarden);
	velden = $.toJSON(velden);
	$.post("ajax/postPersoneelCategorie.php", { "actie":"add", "waarden": waarden ,"velden": velden});
}

//functies om de prentjes in te stellen
function setBewerk(){
	var img = $(this).html("<img/>").find("img");
	img.attr("src", "images/page_edit.gif").addClass("klik").attr("title", "Deze categorie bewerken").attr("alt", "Deze categorie bewerken").click(bewerk);
}
function setVerwijder(){
	$(this).html("<img/>");
}
function setOK(){
	var img = $(this).html("<img/>").find("img");
	img.attr("src", "images/icon_accept.gif").addClass("klik").attr("title", "OK").attr("alt", "OK").click(OK);
}
function setCancel(){
	var img = $(this).html("<img/>").find("img");
	img.attr("src", "images/action_stop.gif").addClass("klik").attr("title", "Cancel").attr("alt", "Cancel").click(cancel);
}
function setVoegtoe(){
	$(this).find("img").addClass("klik").attr("title", "Voeg deze categorie toe").attr("alt", "Voeg deze categorie toe").click(voegtoe);
}