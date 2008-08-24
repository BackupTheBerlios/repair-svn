$(document).ready(function(){
	$(".img1").each(setBewerk);//bewerkfunctionaliteit instellen
	$(".img2").each(setVerwijder);//verwijderfunctionaliteit instellen
	
	$(".img").each(setVoegtoe);
	$("#gebruikersnaam input").keyup(ldapMagic);
});

function bewerk(){
	var rij = $(this).parent().parent();
	
	//tekst velden omzetten
	rij.find(".edit").each(function(){
		var waarde = $(this).html();
		$(this).html("<input type='hidden' value='"+waarde+"'/><input type='text' value='"+waarde+"'/>");
	}).find("input").keyup(function(){
		$.post("ajax/postPersoneelBeheerder.php", { "actie":"ldap", "waarde": $(this).val()}, function(data){
			rij.find(".voornaam").html(data['voornaam']);
			rij.find(".achternaam").html(data['achternaam']);
		},"json");
	});
	
	rij.find(".homes").each(function(){
		$.post("ajax/postPersoneelBeheerder.php", {"actie":"lijst"}, function(data){
			var waarde = rij.find(".homes").html();
			var tekst = "<input type='hidden' value='"+waarde+"'/>";
			for(var i in data){
				tekst +="<label for='home_"+i+"' ><input type='checkbox' ";
				if(rij.find(".homes").html().indexOf(data[i])!=-1)
					tekst += "checked=checked ";
				tekst += "id='home_"+i+"' name='home_"+i+"' class='Home "+data[i]+"' value='"+i+"'/>Home "+data[i]+"</label><br/>";
			}
			rij.find(".homes").html(tekst);
		},"json");
	})
	
	rij.find(".img1").each(setOK);
	rij.find(".img2").each(setCancel);
}

function verwijder(){
	if(confirm("Bent u zeker dat u deze beheerder wilt verwijderen?")){
		$.post("ajax/postPersoneelBeheerder.php", { "actie":"remove", "id": $(this).parent().parent().attr("id").split("_")[0]});
		$(this).parent().html("").parent().addClass("deleted");
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
	
	var lijstje = "";
	var tekstjes = new Array();
	$("input[@type=checkbox]:checked").each(function(){
		lijstje +=$(this).val()+";";
		tekstjes[tekstjes.length] = $(this).attr("class"); 
	});
	velden[velden.length] = "homes";
	waarden[waarden.length] = lijstje;
	
	var h = "";
	for ( var i in tekstjes ){
		h +=tekstjes[i]+"<br/>";
	}
	rij.find(".homes").html(h);
	
	waarden = $.toJSON(waarden);
	velden = $.toJSON(velden);
	$.post("ajax/postPersoneelBeheerder.php", { "actie":"edit", "id": id, "waarden": waarden ,"velden": velden});
	
	rij.find(".img1").each(setBewerk);
	rij.find(".img2").each(setVerwijder);
}

function cancel(){
	var rij = $(this).parent().parent();
	
	//tekst herstellen	
	rij.find(".edit, .homes").each(function(){
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
	var lijstje = "";
	var tekstjes = new Array();
	$("input[@type=checkbox]:checked").each(function(){
		lijstje +=$(this).val()+";";
		tekstjes[tekstjes.length] = $(this).attr("class"); 
	});
	velden[velden.length] = "homes";
	waarden[waarden.length] = lijstje;
	r += "<td>"+$("#voornaam").html()+"</td><td>"+$("#achternaam").html()+"</td><td>";
	for ( var i in tekstjes ){
		r +=tekstjes[i]+"<br/>";
	}
	r += "</td><td></td><td></td></tr>";
	rij.before(r);
	waarden = $.toJSON(waarden);
	velden = $.toJSON(velden);
	$.post("ajax/postPersoneelBeheerder.php", { "actie":"add", "waarden": waarden ,"velden": velden});
	$("#voornaam").html("");
	$("#achternaam").html("");
	$("input[@type=checkbox]:checked").attr("checked","");
}

function ldapMagic(){
	$.post("ajax/postPersoneelBeheerder.php", { "actie":"ldap", "waarde": $(this).val()}, function(data){
		$("#voornaam").html(data['voornaam']);
		$("#achternaam").html(data['achternaam']);
	},"json");
}

//functies om de prentjes in te stellen
function setBewerk(){
	var img = $(this).html("<img/>").find("img");
	img.attr("src", "images/page_edit.gif").addClass("klik").attr("title", "Deze home bewerken").attr("alt", "Deze home bewerken").click(bewerk);
}
function setVerwijder(){
	var img = $(this).html("<img/>").find("img");
	img.attr("src", "images/page_delete.gif").addClass("klik").attr("title", "Deze home verwijderen").attr("alt", "Deze home verwijderen").click(verwijder);
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
	$(this).find("img").addClass("klik").attr("title", "Voeg dit veld toe").attr("alt", "Voeg deze home toe").click(voegtoe);
}