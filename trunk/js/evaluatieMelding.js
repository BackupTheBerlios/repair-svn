function evalueerPositief(formid) {
	var antwoord = confirm("Wilt u deze herstelling(en) echt markeren als geslaagd?");
	if (antwoord) {
		$.post("ajax/evaluatieMelding.php", 
			{ "formid": formid, "evaluatie": 1 }, 
			function(){
				$("#row_"+formid).hide();
			}
		);
	}
}

function evalueerNegatief(formid) {
	alert("not yet implemented");
}