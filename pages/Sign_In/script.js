
// Funzione di submit del form di login
function SubmitLoginForm(form) {
	save_data(); 
	return formTransitionTo(form);
}

// Serve per far apparire lo username nella barra di digitazione se si ha sbagliato la password
function save_data() {

	if (typeof(Storage) !== "undefined") {
		sessionStorage.setItem("username", $("#username-input").val());
	}
}

$(document).ready(function(){
	// Inserisce nel campo il valore della sessionStorage al caricamento della pagina
	$("#username-input").val(sessionStorage.getItem("username"));

	$("input[type=password]").on("keyup", function() {

		if (document.querySelector(".incorrect-password")) {

			$(".incorrect-password").css("height", "0px");
			
			$(".incorrect-password > div").css("animation", "incorrect-password-animation 0.2s forwards");
		}
	});
});