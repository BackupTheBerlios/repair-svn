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
	
	rij.find(".mails").each(function(){
		var waarde = $(this).find("input").attr("value");
		$(this).find("input").removeAttr("disabled");
		$(this).append("<input type='hidden' value='"+waarde+"'/>");
	});
	
	rij.find(".homes").each(function(){
		$.post("ajax/postPersoneelBeheerder.php", {"actie":"lijst"}, function(data){
			var waarde = rij.find(".homes").html();
			var tekst = "<input type='hidden' value='"+waarde+"'/>";
			for(var i in data){
				tekst +="<label for='home_"+i+"' ><input class='inputCheckbox' type='checkbox' ";
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
	
	rij.find(".mails").each(function(){
		$(this).find("input[@type=hidden]").remove();
		var waarde = $(this).find("input[@type=checkbox]").attr("checked");
		if(waarde!="")
			waarde=1;
		else
			waarde=0;
		$(this).find("input[@type=checkbox]").attr("value", waarde).attr("disabled", "disables");
		velden[velden.length] = $(this).find("input[@type=checkbox]").attr("id").split("_")[0];
		waarden[waarden.length] = waarde;
	});
	
	var lijstje = "";
	var tekstjes = new Array();
	$(".homes input[@type=checkbox]:checked").each(function(){
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
	rij.find(".mails").each(function(){
		var oorspronkelijk = $(this).find("input[@type=hidden]").val();
		if(oorspronkelijk=="1")
			$(this).find("input[@type=checkbox]").attr("disabled", "disabled").attr("checked", "checked");
		else
			$(this).find("input[@type=checkbox]").attr("disabled", "disabled").removeAttr("checked");
			
		$(this).find("input[@type=hidden]").remove();
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
	var mails = 0;
	rij.find(".mails").each(function(){
		$(this).find("input[@type=hidden]").remove();
		mails = $(this).find("input[@type=checkbox]").attr("checked");
		if(mails!="")
			mails=1;
		else
			mails=0;
		$(this).find("input[@type=checkbox]").attr("value", mails);
		velden[velden.length] = "mails";
		waarden[waarden.length] = mails;
	});
	var lijstje = "";
	var tekstjes = new Array();
	rij.find(".homes input[@type=checkbox]:checked").each(function(){
		lijstje +=$(this).val()+";";
		tekstjes[tekstjes.length] = $(this).attr("class"); 
	});
	velden[velden.length] = "homes";
	waarden[waarden.length] = lijstje;
	r += "<td>"+$("#voornaam").html()+"</td><td>"+$("#achternaam").html()+"</td><td>";
	for ( var i in tekstjes ){
		r +=tekstjes[i]+"<br/>";
	}
	if(mails=="1")
		r += "</td><td><input type='checkbox' checked='checked' disabled='disabled'/></td><td></td><td></td></tr>";
	else
		r += "</td><td><input type='checkbox' disabled='disabled'/></td><td></td><td></td></tr>";
	rij.before(r);
	waarden = $.toJSON(waarden);
	velden = $.toJSON(velden);
	$.post("ajax/postPersoneelBeheerder.php", { "actie":"add", "waarden": waarden ,"velden": velden});
	$("#voornaam").html("");
	$("#achternaam").html("");
	rij.find("input[@type=checkbox]:checked").attr("checked","");
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
	img.attr("src", "images/page_edit.gif").addClass("klik").attr("title", "Deze beheerder bewerken").attr("alt", "Deze beheerder bewerken").click(bewerk);
}
function setVerwijder(){
	var img = $(this).html("<img/>").find("img");
	img.attr("src", "images/page_delete.gif").addClass("klik").attr("title", "Deze beheerder verwijderen").attr("alt", "Deze beheerder verwijderen").click(verwijder);
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
	$(this).find("img").addClass("klik").attr("title", "Voeg deze beheerder toe").attr("alt", "Voeg deze beheerder toe").click(voegtoe);
}