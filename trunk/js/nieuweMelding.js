function checkVeld(a, checked){
	$("#item_"+a).children().css("backgroundColor", checked ? "#FFCC00" : "white");
}

function checkItem(a){
	$("#item_"+a).find("input[@type$='checkbox']").each(function(){
		this.checked = !this.checked;
		checkVeld(a, this.checked);
	});
}

function showGroup(a){
	var test = $("#group_cat_"+a).css("display");
	if (test == "none") {
		$("#group_cat_"+a).show();
		$("#collapse_"+a).text("-");
	} else {
		$("#group_cat_"+a).hide();
		$("#collapse_"+a).text("+");
	}
}

$(document).ready(function(){
	$("#submit").click(function(){
		// TODO: errorchecking (geen enkel veld ingevuld en ook geen opmerking ingevuld)
		var hasError = false;
		
		// data collectie
		var opmerking = $("#opmerking").val();
		
		var arrayCheckbox = new Array;
		$('input:checked').each(function(){
			arrayCheckbox.push(this.name);
		});
		
		if (hasError == false) {
			$.post("ajax/postNieuweMelding.php", { "velden[]": arrayCheckbox, "opmerking": opmerking},
				function (data){
					$("#beforecontent").before('<div><h1>Success</h1><p>Nieuwe melding werd ingevoerd.</p></div>');
					$("#meldingform").hide();
				});
		}
		return false;
	});
});