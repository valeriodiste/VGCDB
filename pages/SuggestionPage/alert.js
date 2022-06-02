
$(document).ready( function() {

	/* Assegna gli event listener per quando si clicca sulla "x" del warning box oppure fuori dalla warning box mentre è attiva */
	document.querySelector(".block-underneath-content").addEventListener("click", CollapseWarningBox);
	document.querySelector(".close-button").addEventListener("click", CollapseWarningBox);

	/* Espande il box per il messaggio di warning */
	function ExpandWarningBox(message) {
		document.querySelector("#alert").style.animation = "alert-animation-in 0.1s ease-in-out forwards";
		document.querySelector(".alert-box").style.animation = "alert-box-in 0.1s ease-in-out forwards";
		document.querySelector(".block-underneath-content").style.animation = "block-underneath-in 0.01s forwards";
		document.querySelector(".alert-text").innerHTML = message;
	}

	/* Chiude il box per il messaggio di warning */
	function CollapseWarningBox() {
		document.querySelector("#alert").style.animation = "alert-animation-out 0.1s ease-in-out forwards";
		document.querySelector(".alert-box").style.animation = "alert-box-out 0.1s ease-in-out forwards";
		document.querySelector(".block-underneath-content").style.animation = "block-underneath-out 0.01s forwards";
	}

	// Controlla se il numero inserito è compreso tra 1970 e l'anno attuale
	function check_year_number() {
		let val = $("#year_1").val();
		let current = new Date().getFullYear();
		if ( ( val<1970 || val>current ) && val.length>0)  {
			// alert("WARNING!\nThe year of first appearance must be a number between 1970 and the current year (" + current + ")");
			// console.log("something should be happening");
			let message = "WARNING: The year of first appearance must be a number between 1970 and the current year (" + current.toString() + ")";
			ExpandWarningBox(message);
			$("#year_1").val("");
			return false;
		}
		return true;
	}
	// document.getElementById("year_1").addEventListener("change", check_year_number);
	// document.getElementById("year_2").addEventListener("change", check_year_number);


	// Controlla se vengono inseriti caratteri diversi da numeri
	function check_year_string() {
		let val = $("#year_1").val();
		let regex = new RegExp('^[0-9]+$');
		if(!val.match(regex) && val.length>0) {
			// alert("the year must contain only digits");
			let message = "WARNING: The year of first appearance must be a number";
			ExpandWarningBox(message);
			$("#year_1").val("");
			return false;
		}
		return true;
	}
	// document.getElementById("year_1").addEventListener("keyup", check_year_string);
	// document.getElementById("year_2").addEventListener("keyup", check_year_string);


	// Controlla che il valore del primo campo sia minore del secondo
	// function check_year_integrity() {
	// 	let year1 = document.getElementById("year_1").value;
	// 	let year2 = document.getElementById("year_2").value;
	// 	// console.log(year1);
	// 	// console.log(year2);
	// 	if(year1!="" && year2!="") {
	// 		year1 = parseInt(year1);
	// 		year2 = parseInt(year2);
	// 		if(year1>year2||year2<year1) {
	// 			// alert("first value of year must be lower than the second");
	// 			let message = "WARNING: The first year (from) should be lower than the second year (to)";
	// 			ExpandWarningBox(message);
	// 			// document.getElementById("year_1").value = "";
	// 			// document.getElementById("year_2").value = "";
	// 			return false;
	// 		}
	// 		return true;
	// 	}
	// 	return true;
	// }
	// document.getElementById("year_1").addEventListener("change", check_year_integrity);
	// document.getElementById("year_2").addEventListener("change", check_year_integrity);
	
	// Controlla che name e universe NON siano vuoti che year, se presente, sia valido
	function CheckForm() {
		
		if (document.querySelector("#user-is-logged-in") == null) {
			let message = "You must be logged in to suggest a character";
			ExpandWarningBox(message);
			return false;
		}

		let name = $("#character_name").val();
		let universe = $("#universe_name").val();
		
		if (name.length == 0 || universe.length == 0) {
			if (name.length == 0 && universe.length == 0) {
				let message = "Insert a name and a universe for the character you are suggesting";
				ExpandWarningBox(message);
			} else if (name.length == 0) {
				let message = "Insert a name for the character you are suggesting";
				ExpandWarningBox(message);
			} else if (universe.length == 0) {
				let message = "Insert a universe for the character you are suggesting";
				ExpandWarningBox(message);
			}
			return false;
		}


		let toRet = check_year_number() && check_year_string();

		return toRet;
	}

	$("#submit_button").click(CheckForm);

	// Fa comparire il dropdown menu quando si inizia a scrivere nell'input per Universe 
	// $('#universe_name').keyup(showDropdown);
	// $('#universe_name').focusout(showDropdown);

	// Autocompletamento dello "Universe" per quando l'utente clicca su un'opzione dal dropdown menu
	// $("#myDropdown > div").click(function(e) {

	// 	document.getElementById("myDropdown").classList.add("show");

	// 	let text = e.target.querySelector("span").innerHTML;
	// 	$("#universe_name").val(text);

	// 	document.getElementById("myDropdown").classList.remove("show");
	// 	// console.log(text);
	// 	// console.log(e.target);
	// 	// console.log($("#universe_name").val());
	// });

});