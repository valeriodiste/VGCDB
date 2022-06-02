// Resetta i campi del form al loro valore iniziale (infatti, il button con input type"reset" resetta 
//		i valori del form SOLO ai valori di quando la pagina è stata caricata, per cui non resetta i valori di "default")
function ResetHardcodedCheckboxes() {
	$('input[type=checkbox]').each( function (i) {
		if (this.checked) {
			$(this).prop("checked", false);
			
			$(this).parents(".checkbox-div").parent().find(".search-box-menu").css("background-color","");
			$(this).parents(".checkbox-div").css("background-color","");
		}
	});
	$('input[type=text]').each( function (i) {
		if (($(this).val()).length > 0) {
			$(this).val("");
		}
	});
	return false;
}

$(document).ready(function(){

	// Modifica del "layout" della pagina in base alla larghezza
	let originalResultsSectionMargin = $("#results-section").css("margin");
	let originalResultsSectionLeft = $("#results-section").css("left");
	function redrawPageLayout() {
		if (window.innerWidth < 980) {
			$(".search-box").hide();
			$("#results-section").css("width", "100vw");
			$("#results-section").css("left", "0");
			$("#results-section").css("margin", "20px auto 0 auto");
		} else {
			$(".search-box").show();
			$("#results-section").css("width", "calc(100% - 450px)");
			$("#results-section").css("left", originalResultsSectionLeft);
			$("#results-section").css("margin", originalResultsSectionMargin);
		}
	}
	redrawPageLayout();
	$(window).resize(redrawPageLayout);

	// Funzione per gestire la comparsa delle opzioni del form
	var acc = document.getElementsByClassName("search-box-menu");
	for (let i = 0; i < acc.length; i++) {
	  acc[i].addEventListener("click", function() {
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if (panel.style.maxHeight) {
			panel.style.maxHeight = null;
		} else {
			panel.style.maxHeight = panel.scrollHeight + "px";
		}
	  });
	}

	// Controlla il color change delle checkboxes
	$('input[type=checkbox]').change( function(e) {
		let dropdownButton = 	 $(e.target).parents(".checkbox-div").parent().find(".search-box-menu");
		let dropdownBackground = $(e.target).parents(".checkbox-div").css("background-color","var(--dark-red)");
		if (e.target.checked) {
			dropdownButton.css("background-color","var(--primary)");
			dropdownBackground.css("background-color","var(--dark-red)");
		} else {
			let checkBoxes = dropdownBackground.find("input[type=checkbox]");
			let condition = true;
			checkBoxes.each(function(i) {
				condition = condition && !this.checked;
			});
			if (condition) {
				dropdownButton.css("background-color","");
				dropdownBackground.css("background-color","");
			}
		}
	});
	$('input[type=checkbox]').each( function() {
		if (this.checked) {
			$(this).parents(".checkbox-div").parent().find(".search-box-menu").css("background-color","var(--primary)");
			$(this).parents(".checkbox-div").css("background-color","var(--dark-red)");
		}
	});

});