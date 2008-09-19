$(document).ready(function(){
	$(".filter input").keyup(doorsturen);
	$.get("ajax/postPersoneelOverzicht.php", {type:$("table").attr("class")}, parse, "json");
});

function parse(alle_data){
	var paginering = alle_data[0];
	var data = alle_data[1];
	var result="";
	for(key in data){
		result += "<tr>";
		result += "<td class='klik' onclick=\"window.location.href = 'personeelMeldingInformatie.php?formid="+data[key]['id']+"'\"><img title='Meer informatie over dit formulier' src='images/externesite.gif'/></td>";
		result += "<td>"+data[key]['id']+"</td>";		
		result += "<td>"+data[key]['datum']+"</td>";
		result += "<td>"+data[key]['kamer']+"</td>";
		result += "<td>"+data[key]['home']+"</td>";	
		result += "<td>"+data[key]['persoon']+"</td>";		
		result += "<td>"+data[key]['status']+"</td>";	
		result += "<td>"+data[key]['factuurnummer']+"</td>";
		result += "</tr>";
	}
	$("#inhoud").html(result);
	$("#paginering").html(paginering['aantal_rijen']+" resultaten: pagina <input type='text' class='pagina' value='"+paginering['current_page']+"'> van de "+paginering['aantal_paginas']+"  <img class='page' id='terug' src='images/back.gif'/>  <img class='page' id='volgende' src='images/forward.gif'/>");
	
	if (paginering['current_page'] != paginering['aantal_paginas']) {
		$("#terug").addClass("klik").click(function(){
			$("#paginering input").val(parseInt($("#paginering input").val())+1);
			$("#paginering input").keyup();
		});
		
		$("#volgende").addClass("klik").click(function(){
			$("#paginering input").val(parseInt($("#paginering input").val())+1);
			$("#paginering input").keyup();
		});
	}
	$("input.pagina").keyup(doorsturen2);
}

function doorsturen(){
	var velden = new Array();
	var waarden = new Array();
	$(".filter input").each(function(){
		if($(this).val()!=""){
			velden[velden.length] = $(this).attr("id");
			waarden[waarden.length] = $(this).val();
		}
	});
	var v = $.toJSON(velden);
	var w = $.toJSON(waarden);
	$.get("ajax/postPersoneelOverzicht.php", {type:$("table").attr("class"), velden:v, waarden:w}, parse, "json");
}

function doorsturen2(){
	var pagina = $(this).val();
	if(pagina=="") return;
	var velden = new Array();
	var waarden = new Array();
	$(".filter input").each(function(){
		if($(this).val()!=""){
			velden[velden.length] = $(this).attr("id");
			waarden[waarden.length] = $(this).val();
		}
	});
	var v = $.toJSON(velden);
	var w = $.toJSON(waarden);
	$.get("ajax/postPersoneelOverzicht.php", {type:$("table").attr("class"), velden:v, waarden:w, page:pagina}, parse);
}

function update(data){

}