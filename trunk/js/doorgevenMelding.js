function geefDoor(formid){
	$.post("ajax/doorgevenMelding.php", { "formid": formid }, 
		function(data){
			$("#beforecontent").before('<div><h1>Success</h1><p>De melding werd doorgegeven en als "gedaan" gemarkeerd.</p></div>');
			$("#test").hide();
		});
}