function showGroup(a){
	var test = $("#group_status_"+a).css("display");
	if (test == "none")
		$("#group_status_"+a).show();
	else
		$("#group_status_"+a).hide();
}

function verwijder(i){
	var answer = confirm("Wil je dit herstelformulier echt verwijderen?");
	if (answer) {
		$.post("ajax/verwijderHerstelformulier.php", 
			{ formid: i }, 
			function(){
				$("#row_"+i).hide();
			}
		);
	}
}