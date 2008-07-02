function checkVeld(a, checked){
	$("#item_"+a).children().css("backgroundColor", checked ? "red" : "white");
}

$(document).ready(function(){
	$("#submit").click(function(){
		// TODO: errorchecking (geen enkel veld ingevuld en ook geen opmerking ingevuld)
		var hasError = false;
		
		if (hasError == false) {
			$.post("../ajax/postNieuweMelding.php", { 4: on },
				function (data){
					$("#contentHome").before('<h1>Success</h1><p>Nieuwe melding werd ingevoerd.</p>');
				});
		}
		return false;
	});
});