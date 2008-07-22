function checkVeld(a, checked){
	if (checked)
		$("#item_"+a).addClass("selected");
	else
		$("#item_"+a).removeClass("selected");
}

function checkItem(a){
	$("#item_"+a).find("input[@type$='checkbox']").each(function(){
		this.checked = !this.checked;
		checkVeld(a, this.checked);
	});
}

function showGroup(a){
	var text = $("#collapse_"+a).text();
	if (text == "-")
		$("#collapse_"+a).text("+");
	else
		$("#collapse_"+a).text("-");
	
	flipCategorie(a);
}

function flipCategorie(a){
	$("."+a).each(function(){
		var test = $(this).css("display");
		if (test == "none") {
			$(this).show();
		} else {
			if (!$(this).hasClass("selected"))
				$(this).hide();
		}
	});
}

function showLocatie(a){
	$("."+a).each(function(){
		var test = $(this).css("display");
		if (test == "none") {
			$(this).show();
		} else {
			$(this).hide();
		}
	});
}

$(document).ready(function(){
		
	$.get("ajax/getMelding.php", { formid: "5" }, function(data) {
		var i = 0;
		for(item in data) {
			if (i % 2 == 0) {
				showGroup(data[item]);
			} else {
				checkItem(data[item]);
			}
			i++;
		}
	},"json");
	
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
			$.post("ajax/bewerkMelding.php", { "formid": "5", "velden[]": arrayCheckbox, "opmerking": opmerking},
				function (data){
					$("#beforecontent").before('<div><h1>Success</h1><p>Uw melding werd aangepast.</p></div>');
					$("#meldingform").hide();
				});
		}
		return false;
	});
});