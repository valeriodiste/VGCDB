
/* Search Universe Box Dropdown */
function showDropdown() {
	if($('#universe_name').val() && ($('#universe_name').is(":focus") || $('.dropdown').is(":active"))) {
		document.getElementById("myDropdown").classList.add("show");
		document.querySelector(".universe-search-input").classList.remove("show-shadow-border");
	} else {
		document.getElementById("myDropdown").classList.remove("show");
		document.querySelector(".universe-search-input").classList.add("show-shadow-border");
	}
}
/* Filtra gli elementi del dropdown in base all'input dell'utente */
function filterFunction() {
	let input, filter, i;
	let maxDisplayedDropdownOptions = 4;
	input = document.getElementById("universe_name");
	filter = input.value.toLowerCase().replace("-","").replace("'","");
	dropdownOptions = document.querySelectorAll("#myDropdown > div > span");
	for (i = 0; i < dropdownOptions.length; i++) {
		txtValue = dropdownOptions[i].textContent || dropdownOptions[i].innerText;
		// Controlla se il primo indice in cui la stringa "filter" compare nella stringa "txtValue" è > -1 (quindi se la stringa inserita compare tra le opzioni possibili)
		if (txtValue.toLowerCase().replace("-","").replace("'","").indexOf(filter) > -1 && maxDisplayedDropdownOptions > 0) {	
			dropdownOptions[i].style.display = "";
			dropdownOptions[i].parentElement.style.display = "";
			maxDisplayedDropdownOptions--;
		} else {
			dropdownOptions[i].style.display = "none";
			dropdownOptions[i].parentElement.style.display = "none";
		}
	}
}

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
		let val=this.value;
		let current = new Date().getFullYear();
		if ( ( val<1970 || val>current ) && val.length>0)  {
			let message = "WARNING: The year of first appearance must be a number between 1970 and the current year (" + current.toString() + ")";
			ExpandWarningBox(message);
			this.value = "";
		}
	}
	document.getElementById("year_1").addEventListener("change", check_year_number);
	document.getElementById("year_2").addEventListener("change", check_year_number);

	// Controlla se vengono inseriti caratteri diversi da numeri
	function check_year_string() {
		let val = this.value;
		let regex = new RegExp('^[0-9]+$');
		if(!val.match(regex) && val.length>0) {
			let message = "WARNING: The year of first appearance must be a number";
			ExpandWarningBox(message);
			document.getElementById("year_1").value = "";
			document.getElementById("year_2").value = "";
		}
	}
	document.getElementById("year_1").addEventListener("keyup", check_year_string);
	document.getElementById("year_2").addEventListener("keyup", check_year_string);


	// Controlla che il valore del primo campo sia minore del secondo
	function check_year_integrity() {
		let year1 = document.getElementById("year_1").value;
		let year2 = document.getElementById("year_2").value;
		if(year1!="" && year2!="") {
			year1 = parseInt(year1);
			year2 = parseInt(year2);
			if(year1>year2||year2<year1) {
				let message = "WARNING: The first year (from) should be lower than the second year (to)";
				ExpandWarningBox(message);
				return false;
			}
			return true;
		}
		return true;
	}
	document.getElementById("year_1").addEventListener("change", check_year_integrity);
	document.getElementById("year_2").addEventListener("change", check_year_integrity);
	$("#submit_button").click(check_year_integrity);

	// Fa comparire il dropdown menu quando si inizia a scrivere nell'input per Universe 
	$('#universe_name').keyup(showDropdown);
	$('#universe_name').focusout(showDropdown);

	// Autocompletamento dello "Universe" per quando l'utente clicca su un'opzione dal dropdown menu
	$("#myDropdown > div").click(function(e) {

		document.getElementById("myDropdown").classList.add("show");

		let text = e.target.querySelector("span").innerHTML;
		$("#universe_name").val(text);

		document.getElementById("myDropdown").classList.remove("show");
	});

});