function geefDoor(formid, fase){
	if (fase == 0) {
		var tekst = "<tr><td>Factuurnummer:</td><td colspan='2'><input type='text' name='factuurnummer' id='factuurnummer'/></td><td><img alt='doorgeven' class='bewerk klik' title='Deze opmerking doorsturen' src='images/icon_accept.gif' onclick='geefDoor("+formid+", 1);'/></td></tr>";
		$("#submitrow").after(tekst).hide();
	} else {
		var factuurnummer = $("#factuurnummer").val();
		$.post("ajax/doorgevenMelding.php", { "formid": formid, "factuurnummer": factuurnummer }, 
			function(data){
				$("#beforecontent").before('<div><h1>Succes</h1><p>De melding werd doorgegeven en als "gedaan" gemarkeerd.</p></div>');
				$("#test").hide();
			});
	}
}