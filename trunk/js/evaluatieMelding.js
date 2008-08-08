function evalueerPositief(formid) {
	var antwoord = confirm("Wilt u deze herstelling echt markeren als geslaagd?");
	if (antwoord) {
		$.post("ajax/evaluatieMelding.php", 
			{ "formid": formid, "evaluatie": 1 }, 
			function(){
				$("#success").show();
				$("#beforecontent").hide();
			}
		);
	}
}

function evalueerNegatief(formid) {
	var vertaling = $("#opmerkingvertaling").text();
	var velden = "<tr id='new_row_"+formid+"'><td>"+vertaling+":</td><td><textarea name='opmerking' cols='50' rows='8'/></textarea></td><td><img alt='doorgeven' class='bewerk klik' title='Deze opmerking doorsturen' src='images/icon_accept.gif' onclick=\"zendOpmerking("+formid+");\"/></td></tr>";
	$("#row_"+formid).each(function(el){
		$(this).after(velden);
	});
	$("#row_"+formid).find(".klik").each(function(el){
		$(this).hide();
	});
}

function zendOpmerking(formid) {
		var opmerking = $('textarea[name="opmerking"]').val();
		$.post("ajax/evaluatieMelding.php", 
				{ "formid": formid, "evaluatie": 0, "opmerking": opmerking }, 
				function(){
					$("#success").show();
					$("#beforecontent").hide();
				}
			);
		$("#row_"+formid).hide();
		$("#new_row_"+formid).hide();
}