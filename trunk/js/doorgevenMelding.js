function geefDoor(formid, fase){
	if (fase == 0) {
		$(".referentienummer").each(function(el){
			$(this).show();
		});
		$("#opmerkingnummer").show();
		var tekst = "<tr><td colspan='4'></td><td><img alt='doorgeven' class='bewerk klik' title='Deze referentienummers doorsturen' src='images/icon_accept.gif' onclick='geefDoor("+formid+", 1);'/></td></tr>";
		$("#submitrow").after(tekst).hide();
	} else {
		var factuurnummers = new Array();
		$(".factuurnummer").each(function(el){
			var id = $(this).attr("id");
			var nummer = $(this).val();
			factuurnummers[id] = nummer;
		});	
		var opmerkingnummer = $.toJSON($("#opmerkingnummer").val());
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