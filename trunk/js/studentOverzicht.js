function showGroup(a){
	$("."+a).each(function(el){
		var test = $(this).css("display");
		if (test == "none" && !$(this).hasClass("deleted")) {
			$(this).show();
		} else {
			$(this).hide();
		}
	});
	
	var text = $("#collapse_"+a).text();
	if (text == "-")
		$("#collapse_"+a).text("+");
	else
		$("#collapse_"+a).text("-");
}

function verwijder(i){
	var vertaling = $("#verwijderconfirm").text(); 
	var answer = confirm(vertaling);
	if (answer) {
		$.post("ajax/verwijderHerstelformulier.php", 
			{ formid: i }, 
			function(){
				$("#row_"+i).addClass("deleted");
				$("#row_"+i).hide();	
			}
		);
	}
}