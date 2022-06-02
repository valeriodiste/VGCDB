
// Variabile da settare in base al valore della variabile "globale" che indica se l'utente vuole utilizz<are le page trasitions oppure no
usePageTransitions = true; 
if (localStorage.getItem('pageTransitions') == 'false') {
	usePageTransitions = false;
}

// Funzione di transizione per le pagine
function transitionTo(url) {

	if (localStorage.getItem('pageTransitions') == 'false') {
		usePageTransitions = false;
	} else {
		usePageTransitions = true;
	}

	let _url = decodeURIComponent(url);

	if (usePageTransitions) {


		document.querySelector("#page-transition-in").style.display = "block";

		if (_url == "/pages/HomePage/home_page.php" || _url == "/pages/HomePage/home_page.html" || _url == "/index.html") {
			document.querySelector("#menu-bar > .menu-icons").style.animation = "menu-bar-out-homepage 0.45s forwards";
			document.getElementById('page-transition-in').id = 'page-transition-homepage';
		} else {
			document.querySelector("#menu-bar > .menu-icons").style.animation = "menu-bar-out 0.45s forwards";
			document.getElementById('page-transition-in').id = 'page-transition-out';
		}

		/* Closes Menu if expanded */
		if (parseFloat(window.getComputedStyle(document.querySelector("#menu-expanded")).width) > 10) {
			document.querySelector("#menu-expanded").style.animation = "left-menu-out 0.3s ease-out forwards";
		}
		
		/* Closes Login if expanded */
		if (document.getElementById("login-expanded") && parseFloat(window.getComputedStyle(document.querySelector("#login-expanded")).width) > 10) {
			document.querySelector("#login-expanded").style.animation = "right-menu-out 0.3s ease-out forwards";
		}
	
		/* Fades out the icons of the menu bar (menu button, input button and "vgcdb" text) */
		document.querySelectorAll("#menu-bar > .menu-icons > div").forEach( function(element) { 
			element.style.animation = "opacity-out 0.45s forwards";
		} );
	
		setTimeout(function () {
			window.location.href = _url;
		}, 450);

	} else {

		window.location.href = _url;
	}

}

// Funzione di transizione per i form
function formTransitionTo(form) {
	
	if (localStorage.getItem('pageTransitions') == 'false') {
		usePageTransitions = false;
	} else {
		usePageTransitions = true;
	}

	if (usePageTransitions) {

		document.querySelector("#page-transition-in").style.display = "block";

		document.querySelector("#menu-bar > .menu-icons").style.animation = "menu-bar-out 0.45s forwards";
		document.getElementById('page-transition-in').id = 'page-transition-out';

		/* Closes Menu if expanded */
		if (parseFloat(window.getComputedStyle(document.querySelector("#menu-expanded")).width) > 10) {
			document.querySelector("#menu-expanded").style.animation = "left-menu-out 0.3s ease-out forwards";
		}
		
		/* Closes Login if expanded */
		if (document.querySelector("#login-expanded") && parseFloat(window.getComputedStyle(document.querySelector("#login-expanded")).width) > 10) {
			document.querySelector("#login-expanded").style.animation = "right-menu-out 0.3s ease-out forwards";
		}
		
		/* Fades out the icons of the menu bar (menu button, input button and "vgcdb" text) */
		document.querySelectorAll("#menu-bar > .menu-icons > div").forEach( function(element) { 
			element.style.animation = "opacity-out 0.45s forwards";
		} );
	
		setTimeout(function () {

			form.submit();

		}, 450);

		return false;

	} else {

		form.submit();

		return false;

	}
}

$(document).ready(function () {
	if (usePageTransitions) {

		if (!document.getElementById("loader-animation")) {
			document.querySelector("#menu-bar > .menu-icons").style.animation = "menu-bar-in 0.45s forwards";
		} else {
			// La pagina corrente è l'homepage
			document.querySelector("#menu-bar > .menu-icons").style.backgroundColor = "var(--primary)";
		}

		document.querySelector("#page-transition-in").style.display = "block";

	} else {
		document.querySelector("#page-transitions-switch input[type=checkbox]").checked = false;

		document.querySelector("#page-transition-in").style.display = "none";
		if (!document.getElementById("loader-animation")) {
			document.querySelector("#menu-bar > .menu-icons").style.backgroundColor = "var(--primary)";
		} else {
			// La pagina corrente è l'homepage
			document.querySelector("#menu-bar > .menu-icons").style.backgroundColor = "var(--primary)";
		}
		
	}
});

