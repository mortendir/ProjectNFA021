
function checkFormItems() {
	var sourceLanguage = document.getElementById("source_language").value;
	var targetLanguage = document.getElementById("target_language").value;
	if (sourceLanguage === "" || targetLanguage === "") {
		alert("Choose language!");
		return false;
	}
	if (sourceLanguage === targetLanguage) { 
		alert("You cannot choose the same language for source and target language!");
		return false; 
	} else {
		return true;
	}
}




