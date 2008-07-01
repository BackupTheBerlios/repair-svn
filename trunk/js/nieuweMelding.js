function checkVeld(a, checked){
	$("#item_"+a).children().css("backgroundColor", checked ? "red" : "white");
}