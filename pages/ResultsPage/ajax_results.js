$(document).ready(function(){

	$('#search-form').submit(function(e){

		e.preventDefault();
		$.ajax({
			url: "search_results.php",
			type: "POST",
			data: $(this).serialize(),
			success: function(data) {
				$("#results-section").html(data);
				fitAllText();
				ClickOnHorizontalCharacterCards();
			},
			error: function(){
				alert("Form submission failed!");
			}
		});
		
	});

});

