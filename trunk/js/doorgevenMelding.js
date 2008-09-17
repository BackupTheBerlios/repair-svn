function geefDoor(formid, fase){
	if (fase == 0) {
		$(".referentienummer").each(function(el){
			$(this).show();
		});
		$("#opmerkingnummer").show();
		$("#submitrow").hide();
		$("#laatsterow").show();
	} else {
		var factuurnummers = new Array();
		$(".referentienummer").each(function(el){
			var factuurrow = $(this).find(".factuurnummer");
			var id = factuurrow.attr("id");
			var nummer = factuurrow.val();
			factuurnummers[id] = nummer;
		});	
		var opmerkingnummer = $.toJSON($("#opmerkingnummer").find(".factuurnummer").val());
		var zenddoor = $.toJSON(factuurnummers);
		$.post("ajax/doorgevenMelding.php", { "formid": formid, "factuurnummers": zenddoor, "opmerkingnummer": opmerkingnummer }, 
			function(data){
				if (data == "SUCCESS")
					$("#beforecontent").before('<div><h1>Succes</h1><p>De melding werd doorgegeven en als "gedaan" gemarkeerd.</p></div>').hide();
				else
					$("#beforecontent").before('<div><h1>Fout</h1><p>Er was een probleem bij het afwerking van deze melding. Onze excuses voor het ongemak, gelieve het later nog eens te proberen.</p></div>').hide();
			});
	}
}