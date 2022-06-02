


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

// Validazione del campo password
function ValidatePassword() {

	let passwordInput = $("#password-input");
	let letter = $("#letter");
	let capital = $("#capital");
	let number = $("#number");
	let length = $("#length");
	
	// Mostra il box di messaggio quando l'utente clicca sul campo della password
	passwordInput.focus(function() {
		$(".password-validation").css("height", "230px");
		$(".password-validation > div").css("animation", "password-validation-in 0.2s forwards");
	});
	
	// Nasconde il box di messaggio quando l'utente clicca fuori dal campo della password
	passwordInput.blur(function() {
		setTimeout(() => {
			$(".password-validation").css("height", "0px");
			$(".password-validation > div").css("animation", "password-validation-out 0.2s forwards");
		}, 100);
	});
	
	// Aggiorna i check per la password mentre l'utente sta digitando
	passwordInput.on("keyup", function() {

		// Lettera minuscola
		var lowerCaseLetters = /[a-z]/g;
		if(passwordInput.val().match(lowerCaseLetters)) {
			letter.removeClass("not-valid");
			letter.addClass("is-valid");
		} else {
			letter.removeClass("is-valid");
			letter.addClass("not-valid");
		}
		
		// Lettera maiuscola
		var upperCaseLetters = /[A-Z]/g;
		if(passwordInput.val().match(upperCaseLetters)) {
			capital.removeClass("not-valid");
			capital.addClass("is-valid");
		} else {
			capital.removeClass("is-valid");
			capital.addClass("not-valid");
		}
		
		// Numero
		var numbers = /[0-9]/g;
		if (passwordInput.val().match(numbers)) {
			number.removeClass("not-valid");
			number.addClass("is-valid");
		} else {
			number.removeClass("is-valid");
			number.addClass("not-valid");
		}
		
		// 8 caratteri
		if (passwordInput.val().length >= 8) {
			length.removeClass("not-valid");
			length.addClass("is-valid");
		} else {
			length.removeClass("is-valid");
			length.addClass("not-valid");
		}
	});

}

$(document).ready(function() {

	ValidatePassword();

});