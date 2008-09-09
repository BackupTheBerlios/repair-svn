function geefDoor(formid, fase){
	if (fase == 0) {
		var tekst = "<tr><td>Referentienummer:</td><td colspan='2'><input type='text' name='factuurnummer' id='factuurnummer'/></td><td><img alt='doorgeven' class='bewerk klik' title='Deze opmerking doorsturen' src='images/icon_accept.gif' onclick='geefDoor("+formid+", 1);'/></td></tr>";
		$("#submitrow").after(tekst).hide();
	} else {
		var factuurnummer = $("#factuurnummer").val();
		$.post("ajax/doorgevenMelding.php", { "formid": formid, "factuurnummer": factuurnummer }, 
			function(data){
				if (data == "SUCCESS")
					$("#beforecontent").before('<div><h1>Succes</h1><p>De melding werd doorgegeven en als "gedaan" gemarkeerd.</p></div>').hide();
				else
					$("#beforecontent").before('<div><h1>Fout</h1><p>Er was een probleem bij het afwerking van deze melding. Onze excuses voor het ongemak, gelieve het later nog eens te proberen.</p></div>').hide();
			});
	}
}