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
	$("#group_cat_"+a).show();
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