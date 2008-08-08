function showGroup(a){
	var test = $("#group_status_"+a).css("display");
	if (test == "none") {
		$("#group_status_"+a).show();
		$("#collapse_"+a).text("-");
	} else {
		$("#group_status_"+a).hide();
		$("#collapse_"+a).text("+");
	}
}

function verwijder(i){
	var vertaling = $("#verwijderconfirm").text(); 
	var answer = confirm(vertaling);
	if (answer) {
		$.post("ajax/verwijderHerstelformulier.php", 
			{ formid: i }, 
			function(){
				$("#row_"+i).hide();
			}
		);
	}
}