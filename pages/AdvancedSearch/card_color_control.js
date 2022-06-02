
$(document).ready( function() {

	var c1 = "var(--secondary)";
	var c2 = $('.menu-box').css("background-color");
	

	// Gestione del colore per character_box
	function character_checked() {
		if($('#character_name').val()) {
			$('#character_name_box').css('background-color', c1);
			$('#character_name_box').css('transition', "0.5s");
		}
		else {
			$('#character_name_box').css('background-color', c2);
			$('#character_name_box').css('transition', "0.5s");
		} 
	}
	$('#character_name').keyup(character_checked);
	$('#character_name').change(character_checked);


	// Gestione del colore per universe_box
	function universe_checked() {
		if($('#universe_name').val()) {
			$('#universe_box').css('background-color', c1);
			$('#universe_box').css('transition', "0.5s");
		}
		else {
			$('#universe_box').css('background-color', c2);
			$('#universe_box').css('transition', "0.5s");
		}
	}
	$('#universe_name').keyup(universe_checked);
	$('#universe_name').change(universe_checked);


	// Gestione del colore per year_box
	function year_checked() {
		if($('#year_1').val()||$('#year_2').val()) {
			$('#year_box').css('background-color', c1);
			$('#year_box').css('transition', "0.5s");
		}
		else {
			$('#year_box').css('background-color', c2);
			$('#year_box').css('transition', "0.5s");
		} 
	}
	$('#year_1').keyup(year_checked);
	$('#year_1').change(year_checked);
	$('#year_2').keyup(year_checked);
	$('#year_2').change(year_checked);


	// Gestione del colore per eye_box
	function eye_checked() {
		if($('#eye_black').is(':checked')||$('#eye_blue').is(':checked')||
		$('#eye_brown').is(':checked')||$('#eye_green').is(':checked')||
		$('#eye_gray').is(':checked')||$('#eye_orange').is(':checked')||
		$('#eye_purple').is(':checked')||$('#eye_red').is(':checked')||
		$('#eye_white').is(':checked')||$('#eye_yellow').is(':checked')||
		$('#eye_pink').is(':checked')||$('#eye_none').is(':checked')) {
			$('#eye_box').css('background-color', c1);
			$('#eye_box').css('transition', "0.5s");
		}   
		else {
			$('#eye_box').css('background-color', c2);
			$('#eye_box').css('transition', "0.5s");
		}
	}
	$('#eye_black').change(eye_checked);
	$('#eye_blue').change(eye_checked);
	$('#eye_brown').change(eye_checked);
	$('#eye_green').change(eye_checked);
	$('#eye_gray').change(eye_checked);
	$('#eye_orange').change(eye_checked);
	$('#eye_purple').change(eye_checked);
	$('#eye_red').change(eye_checked);
	$('#eye_white').change(eye_checked);
	$('#eye_yellow').change(eye_checked);
	$('#eye_pink').change(eye_checked);
	$('#eye_none').change(eye_checked);


	// Gestione del colore per hair_box
	function hair_checked() {
		if($('#hair_black').is(':checked')||$('#hair_blue').is(':checked')||
		$('#hair_brown').is(':checked')||$('#hair_green').is(':checked')||
		$('#hair_gray').is(':checked')||$('#hair_orange').is(':checked')||
		$('#hair_purple').is(':checked')||$('#hair_red').is(':checked')||
		$('#hair_white').is(':checked')||$('#hair_yellow').is(':checked')||
		$('#hair_pink').is(':checked')||$('#hair_sky_blue').is(':checked')||
		$('#hair_none').is(':checked')) {
			$('#hair_box').css('background-color', c1);
			$('#hair_box').css('transition', "0.5s");
		}   
		else {
			$('#hair_box').css('background-color', c2);
			$('#hair_box').css('transition', "0.5s");
		}
	}
	$('#hair_black').change(hair_checked);
	$('#hair_blue').change(hair_checked);
	$('#hair_brown').change(hair_checked);
	$('#hair_green').change(hair_checked);
	$('#hair_gray').change(hair_checked);
	$('#hair_orange').change(hair_checked);
	$('#hair_purple').change(hair_checked);
	$('#hair_red').change(hair_checked);
	$('#hair_white').change(hair_checked);
	$('#hair_yellow').change(hair_checked);
	$('#hair_pink').change(hair_checked);
	$('#hair_sky_blue').change(hair_checked);
	$('#hair_none').change(hair_checked);


	// Gestione del colore per role_box
	function role_checked() {
		if($('#protagonist').is(':checked')||$('#antagonist').is(':checked')||
		$('#secondary').is(':checked')||$('#enemy').is(':checked')||
		$('#neutral').is(':checked')) {
			$('#role_box').css('background-color', c1);
			$('#role_box').css('transition', "0.5s");
		}   
		else {
			$('#role_box').css('background-color', c2);
			$('#role_box').css('transition', "0.5s");
		}  
	}
	$('#protagonist').change(role_checked);
	$('#antagonist').change(role_checked);
	$('#secondary').change(role_checked);
	$('#enemy').change(role_checked);
	$('#neutral').change(role_checked);


	// Gestione del colore per gender_box
	function gender_checked() {
		if($('#male').is(':checked')||$('#female').is(':checked')||
		$('#other').is(':checked')) {
			$('#gender_box').css('background-color', c1);
			$('#gender_box').css('transition', "0.5s");;
		}   
		else {
			$('#gender_box').css('background-color', c2);
			$('#gender_box').css('transition', "0.5s");
		}
	}
	$('#male').change(gender_checked);
	$('#female').change(gender_checked);
	$('#other').change(gender_checked);


	// Gestione del colore per reset_button
	function reset() {
		$('#character_name_box').css('background-color', c2);
		$('#character_name_box').css('transition', "0.5s");
		$('#universe_box').css('background-color', c2);
		$('#universe_box').css('transition', "0.5s");
		$('#year_box').css('background-color', c2);
		$('#year_box').css('transition', "0.5s");
		$('#eye_box').css('background-color', c2);
		$('#eye_box').css('transition', "0.5s");
		$('#hair_box').css('background-color', c2);
		$('#hair_box').css('transition', "0.5s");
		$('#role_box').css('background-color', c2);
		$('#role_box').css('transition', "0.5s");
		$('#gender_box').css('background-color', c2);
		$('#gender_box').css('transition', "0.5s")
	}
	$('#reset_button').click(reset);
});
