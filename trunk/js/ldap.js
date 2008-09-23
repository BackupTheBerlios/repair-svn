$(document).ready(function(){
	$(".filter input").keyup(doorsturen);
});

function parse(alle_data){
	var paginering = alle_data[0];
	var data = alle_data[1];
	var result="";
	for(key in data){
		result += "<tr>";
		result += "<td>"+data[key]['gebruikersnaam']+"</td>";		
		result += "<td>"+data[key]['voornaam']+"</td>";
		result += "<td>"+data[key]['achternaam']+"</td>";
		result += "<td>"+data[key]['home']+"</td>";	
		result += "<td>"+data[key]['kamer']+"</td>";
		result += "</tr>";
	}
	$("#inhoud").html(result);
}
var vorige;
function doorsturen(){
	var velden = new Array();
	var waarden = new Array();
	$(".filter input").each(function(){
		if($(this).val().length>4){
			velden[velden.length] = $(this).attr("id");
			waarden[waarden.length] = $(this).val();
		}
	});
	var v = $.toJSON(velden);
	var w = $.toJSON(waarden);
	if(vorige != w){
		vorige=w;
		$.get("ajax/postLdap.php", {type:$("table").attr("class"), velden:v, waarden:w}, parse, "json");
		//$.get("ajax/postLdap.php", {type:$("table").attr("class"), velden:v, waarden:w}, function(data){alert(data);});
	}
}