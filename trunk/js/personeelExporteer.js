$(document).ready(function(){
	$("#selecteer_alles").click(function(){
		$("form input").attr("checked", "checked");
	});
	$("#doorsturen").click(function(event){		
		event.preventDefault();
		var waarden="";
		$("form input:checked").each(function(){
			waarden += $(this).val()+";";
		});
		$("#formulier").append("<input type='hidden' name='waarden' value='"+waarden+"'/>");
		$("#formulier").submit();
	});
});