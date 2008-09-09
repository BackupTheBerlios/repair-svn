$(document).ready(function(){
	$(".img1").each(setBewerk);//bewerkfunctionaliteit instellen
	$(".img2").each(setVerwijder);//verwijderfunctionaliteit instellen
	
	addDropdowns();
	$(".img").each(setVoegtoe);
});

function bewerk(){
	var rij = $(this).parent().parent();
	
	//tekst velden omzetten
	rij.find(".edit").each(function(){
		var waarde = $(this).html();
		$(this).html("<input type='hidden' value='"+waarde+"'/><input type='text' value='"+waarde+"'/>");
	});
	
	//selects omzetten
	rij.find(".select").each(function(){
		var waarde = $(this).html();
		var content = "<input type='hidden' value='"+waarde+"'/>";
		setDropDownValues($(this).attr("id").split("_")[0], waarde, $(this), content, rij.attr("id").split("_")[1]);
	});
	
	rij.find(".img1").each(setOK);
	rij.find(".img2").each(setCancel);
}

function verwijder(){
	if(confirm("Bent u zeker dat u dit veld wilt verwijderen?")){
		$.post("ajax/postPersoneelAdmin.php", { "actie":"remove", "id": $(this).parent().parent().attr("id").split("_")[0]});
		$(this).parent().html("").parent().addClass("deleted");
	}
}

function OK(){
	var rij = $(this).parent().parent();
	var id = rij.attr("id").split("_")[0];
	var velden = new Array();
	var waarden = new Array();
	
	rij.find(".edit, .select").each(function(){
		var waarde = $(this).find("input[@type=text], select").val();
		var tekst = waarde;
		
		$(this).find("input[@type=text]").each(function(){tekst = waarde;});
		$(this).find("select").each(function(){tekst = $(this).find("option[@value="+$(this).val()+"]").html();});
		velden[velden.length] = $(this).attr("id").split("_")[0];
		waarden[waarden.length] = waarde;
		$(this).html(tekst);
	});
	
	waarden = $.toJSON(waarden);
	velden = $.toJSON(velden);
	$.post("ajax/postPersoneelAdmin.php", { "actie":"edit", "id": id, "waarden": waarden ,"velden": velden});
	
	rij.find(".img1").each(setBewerk);
	rij.find(".img2").each(setVerwijder);
}

function cancel(){
	var rij = $(this).parent().parent();
	
	//tekst herstellen	
	rij.find(".edit, .select").each(function(){
		$(this).html($(this).find("input[@type=hidden]").val());
	});
	
	rij.find(".img1").each(setBewerk);
	rij.find(".img2").each(setVerwijder);
}

function voegtoe(){
	var rij = $(this).parent().parent();
	var velden = new Array();
	var waarden = new Array();
	var r = "<tr>";
	
	rij.find(".edit, .select").each(function(){
		var waarde = $(this).find("input[@type=text], select").val();
		var tekst = waarde;
		
		$(this).find("input[@type=text]").each(function(){tekst = waarde;});
		$(this).find("select").each(function(){tekst = $(this).find("option[@value="+$(this).val()+"]").html();});
		velden[velden.length] = $(this).attr("id").split("_")[0];
		waarden[waarden.length] = waarde;
		$(this).find("input[@type=text]").val("");
		r += "<td>"+tekst+"</td>";
	});
	r += "<td></td><td></td></tr>";
	rij.before(r);
	waarden = $.toJSON(waarden);
	velden = $.toJSON(velden);
	$.post("ajax/postPersoneelAdmin.php", { "actie":"add", "waarden": waarden ,"velden": velden, "home":rij.attr("id").split("_")[1]});
}

function addDropdowns(){
	$(".dd").each(function(){
		setDropDownValues($(this).attr("id").split("_")[0], "", $(this), "", $(this).attr("id").split("_")[1]);
	});
}

function setDropDownValues(property, waarde, cel, content, locatie){
	$.post("ajax/postPersoneelAdmin.php", {actie:"select", property:property, locatie:locatie}, function(data){	
		var r = "<select>";
		for(key in data){
			r += "<option value='"+key+"'";
			if(data[key]==waarde)
				r += " selected='yes'";
			r += ">"+data[key]+"</option>";
		}
		r += "</select>";
		cel.html(content+r);
	},"json");
	//$.post("ajax/postPersoneelAdmin.php", {actie:"select", property:property, locatie:locatie}, function(data){alert(data);});
} 

//functies om de prentjes in te stellen
function setBewerk(){
	var img = $(this).html("<img/>").find("img");
	img.attr("src", "images/page_edit.gif").addClass("klik").attr("title", "Dit veld bewerken").attr("alt", "Dit veld bewerken").click(bewerk);
}
function setVerwijder(){
	var img = $(this).html("<img/>").find("img");
	img.attr("src", "images/page_delete.gif").addClass("klik").attr("title", "Dit veld verwijderen").attr("alt", "Dit veld verwijderen").click(verwijder);
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
	$(this).find("img").addClass("klik").attr("title", "Voeg dit veld toe").attr("alt", "Voeg dit veld toe").click(voegtoe);
}