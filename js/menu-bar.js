let USER_LOGGED_IN;		// Variabile da settare a true se l'utente è loggato

// Permette il corretto funzionamento del "bottone" "element" 
//		(cioè "trasferisce" il comportamento del link "a" all'intero "div" che fa da bottone)
function AssignLinkToWholeMenuButton(element) {

	element.addEventListener("click", (e) => {
		if (e.target.querySelector("a")) {
			let url = e.target.querySelector("a").href;
			if (url.length > 0) {
				if (url[0] == 'j') {
					let real_url = url.slice(25, -2);
					window["transitionTo"](real_url);
				} else {
					window.location.href = url;
				}
			} else {
				console.log("Element has no url");
			}
		}
	})
}

$(document).ready(function() {

	if(document.getElementById("login-expanded")) {
		USER_LOGGED_IN = true;
	} else {
		USER_LOGGED_IN = false;
	}

	// Sets dark mode
	if (localStorage.getItem('darkMode') == 'true') {
		document.querySelector(':root').style.setProperty('--dark-mode', 1);

		document.querySelector("#menu-expanded #dark-mode-switch input").checked = true;
		
	} else {
		document.querySelector(':root').style.setProperty('--dark-mode', 0);

		document.querySelector("#menu-expanded #dark-mode-switch input").checked = false;
		
	}

	/* Se non si è nell'home page */
	if (document.querySelector("#loader-animation") == null) {
		document.querySelectorAll("#menu-bar > .menu-icons > div").forEach( function(element) { 
			element.style.animation = "opacity-in 0.45s forwards";
		} );
	}

	/* ---------------------------- Menu Section ---------------------------------------- */

	/* Click on "menu" button */
	document.querySelector("#menu-bar > .menu-icons > .menu").addEventListener("click", function() {
		document.querySelector("#menu-expanded").style.animation = "left-menu-in 0.3s ease-out forwards";
		document.querySelector("#click-area-outside").style.animation = "click-outside-menu-active 0.3s forwards";
		
		/* Closes Login if expanded */
		if (document.getElementById("login-expanded") && parseFloat(window.getComputedStyle(document.querySelector("#login-expanded")).width) > 10) {
			document.querySelector("#login-expanded").style.animation = "right-menu-out 0.3s ease-out forwards";
		}
	});

	/* Click on "close menu" button */
	document.querySelector("#menu-expanded > .menu-content > #close-menu").addEventListener("click", function() {
		document.querySelector("#menu-expanded").style.animation = "left-menu-out 0.3s ease-out forwards";
		document.querySelector("#click-area-outside").style.animation = "click-outside-menu-inactive 0.3s forwards";
	});

	/* Click outside the menu area when the menu or login are opened (expanded) */
	document.querySelector("#click-area-outside").addEventListener("click", function() {
		
		/* Closes Menu if expanded */
		if (parseFloat(window.getComputedStyle(document.querySelector("#menu-expanded")).width) > 10) {
			document.querySelector("#menu-expanded").style.animation = "left-menu-out 0.3s ease-out forwards";
			document.querySelector("#click-area-outside").style.animation = "click-outside-menu-inactive 0.3s forwards";
		}

		/* Closes Login if expanded */
		if (document.getElementById("login-expanded") && parseFloat(window.getComputedStyle(document.querySelector("#login-expanded")).width) > 10) {
			document.querySelector("#login-expanded").style.animation = "right-menu-out 0.3s ease-out forwards";
			document.querySelector("#click-area-outside").style.animation = "click-outside-menu-inactive 0.3s forwards";
		}
	});

	document.querySelectorAll("#menu-bar #go-to-page").forEach( function (element) { AssignLinkToWholeMenuButton(element) });
	
	if (document.querySelector("#menu-bar #logout")) {
		document.querySelectorAll("#menu-bar #logout").forEach( function (element) { 

			AssignLinkToWholeMenuButton(element);
	
		});
	}
	

	document.querySelector("#menu-expanded #page-transitions-switch label.switch").addEventListener("click", function() {
		setTimeout(() => {
			if (document.querySelector("#menu-expanded #page-transitions-switch input").checked) {
				// CODICE PER SETTARE LA VARIABILE "GLOBALE" PER LA PAGE TRANSITION A TRUE

				localStorage.setItem('pageTransitions', 'true');

			} else {
				// CODICE PER SETTARE LA VARIABILE "GLOBALE" PER LA PAGE TRANSITION A FALSE

				localStorage.setItem('pageTransitions', 'false');

				document.querySelector("#page-transition-in").style.display = "none";
			}
		},10);
	});

	document.querySelector("#menu-expanded #dark-mode-switch label.switch").addEventListener("click", function() {
		setTimeout(() => {
			if (document.querySelector("#menu-expanded #dark-mode-switch input").checked) {
				document.querySelector(':root').style.setProperty('--dark-mode', 1);

				localStorage.setItem('darkMode', 'true');
				// sessionStorage.setItem('darkMode', 'true');
			} else {
				document.querySelector(':root').style.setProperty('--dark-mode', 0);
				
				localStorage.setItem('darkMode', 'false');
				// sessionStorage.setItem('darkMode', 'false');
			}
		},10);
	});

	/* ---------------------------- Login Section ---------------------------------------- */

	if (USER_LOGGED_IN) {
		/* Click on "login" button */
		document.querySelector("#menu-bar > .menu-icons > .login").addEventListener("click", function() {
		document.querySelector("#login-expanded").style.animation = "right-menu-in 0.3s ease-out forwards";
		document.querySelector("#click-area-outside").style.animation = "click-outside-menu-active 0.3s forwards";
		
		/* Closes Menu if expanded */
		if (parseFloat(window.getComputedStyle(document.querySelector("#menu-expanded")).width) > 10) {
			document.querySelector("#menu-expanded").style.animation = "left-menu-out 0.3s ease-out forwards";
		}
	});

		/* Click on "close menu" button */
		document.querySelector("#login-expanded > .login-content > #close-login").addEventListener("click", function() {
			document.querySelector("#login-expanded").style.animation = "right-menu-out 0.3s ease-out forwards";
			document.querySelector("#click-area-outside").style.animation = "click-outside-menu-inactive 0.3s forwards";
		});
	} else {
		/* Click on "login" button */
		document.querySelector("#menu-bar > .menu-icons > .login").addEventListener("click", function() {
			window["transitionTo"]('/pages/Sign_In/sign_in_page.php');
		});
	}
	
});