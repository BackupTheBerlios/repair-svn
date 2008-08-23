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
	$("#new_row").show();
	$("#acties").hide();
}

function zendOpmerking(formid) {
		var opmerking = $('textarea[name="opmerking"]').val();
		$.post("ajax/evaluatieMelding.php", 
				{ "formid": formid, "evaluatie": 0, "opmerking": opmerking }, 
				function(data){
					if (data != "SUCCESS")
						$("#error").show();
					else
						$("#negatiefsuccess").show();
					$("#beforecontent").hide();
				}
			);
}