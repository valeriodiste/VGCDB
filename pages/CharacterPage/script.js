
// Usata per ricordare se il personaggio è stato inserito nei Favourites dell'utente oppure no
let CHARACTER_IS_IN_FAVOURITES = false;			

$("document").ready(function() {

	if(document.querySelector('#in-favourites')) {
		CHARACTER_IS_IN_FAVOURITES = true;
	}
	
	document.querySelector('.favourite').addEventListener('click', popParticles);

	if (CHARACTER_IS_IN_FAVOURITES == true) {
		let favouriteText = document.querySelector(".favourite > div > h5");
		favouriteText.textContent = "Remove from favourites";

		if (document.querySelector("#star-empty")) {
			let star = document.querySelector("#star-empty");
			star.id = "star-full";
		}
	} else {
		let favouriteText = document.querySelector(".favourite > div > h5");
		favouriteText.textContent = "Add to your favourites";

		if (document.querySelector("#star-full")) {
			let star = document.querySelector("#star-full");
			star.id = "star-empty";
		}
		
	}

	// Gestione dei "favourites" per l'utente (AJAX)
	$('#hidden-favourite-form').submit(function(e){
		
		e.preventDefault();
		$.ajax({
			url: "favourite_character.php",
			type: "POST",
			data: $("#hidden-favourite-form").serialize(),
			success: function() {
				let text = $(".favourite > div > h6").html();
				let texts = text.split(" ");
				text = texts[0];
				text = text.replaceAll('.',"");
				let num = parseInt(text);
				if (document.querySelector("#star-empty")) {	// Rimozione dai preferiti
					num = num - 1;
				} else if (document.querySelector("#star-full")) {		// Aggiunta ai preferiti
					num = num + 1;
				}
				text = num.toString().split("").reverse().join("");
				text = text.replace(/(.{3})/g,"$1.").split("").reverse().join("");

				$(".favourite > div > h6").html(text + " " + texts[1]);

			},
			error: function() {
				alert("Couldn't add character to favourite...");
				return;
			}
		});
		
	});

});

// Funzione per il click sull'universo
function SameUniverseSearch() {
	formTransitionTo(document.querySelector("#hidden-form"));
}

// Animazione per la star icon (aggiunta ai preferiti)
function popParticles(e) {

	// Se l'utente è loggato
	if (document.querySelector("#login-expanded")) {

		if (document.querySelector("#star-empty")) {	// Aggiunta ai preferiti

			let favouriteText = document.querySelector(".favourite > div > h5");
			favouriteText.textContent = "Remove from favourites";
	
			let star = document.querySelector("#star-empty");
			star.id = "star-full";
	
			let amount = 20;
			let distance = 350;
	
			let maxParticleWidth = 50;	// dimensione massima di una particle (in pixel)
			let minParticleWidth = 20;	// dimensione minima di una particle (in pixel)
	
			for (let i = 0; i < amount; i++) {
				createParticle(e.clientX, e.clientY + window.scrollY, distance, maxParticleWidth, minParticleWidth);
			}
			
			// AJAX per aggiornare il database
			$("#hidden-favourite-form > #form-add").val("value", "addcharacter");
			$("#hidden-favourite-form").submit();
	
		} else if (document.querySelector("#star-full")) {		// Rimozione dai preferiti
			
	
			let favouriteText = document.querySelector(".favourite > div > h5");
			favouriteText.textContent = "Add to your favourites";
	
			let star = document.querySelector("#star-full");
			star.id = "star-empty";
	
			// AJAX per aggiornare il database
			$("#hidden-favourite-form > #form-add").val("");
			$("#hidden-favourite-form").submit();
	
		}

	} else {
		transitionTo("/pages/Sign_In/sign_in_page.php");
	}

}
function createParticle(x, y, distance, maxParticleWidth, minParticleWidth) {

	const particle = document.createElement('div');
	document.body.prepend(particle);

	let width = Math.floor(Math.random() * (maxParticleWidth - minParticleWidth) + minParticleWidth);
	let height = width;
	let destinationX = (Math.random() - 0.5) * distance;
	let destinationY = (Math.random() - 0.5) * distance;
	let rotation = Math.random() * 520;
	let delay = Math.random() * 200;

	particle.className = "icon-dark-mode-responsive particle-style";

	particle.style.width = `${width}px`;
	particle.style.height = `${height}px`;
	const animation = particle.animate([
		{
			transform: `translate(-50%, -50%) translate(${x}px, ${y}px) rotate(0deg)`,
			opacity: 1
		},
		{
			transform: `translate(-50%, -50%) translate(${x + destinationX}px, ${y + destinationY}px) rotate(${rotation}deg)`,
			opacity: 0
		}
	], {
		duration: Math.random() * 1000 + 5000,
		easing: 'cubic-bezier(0, .9, .57, 1)',
		delay: delay
	});
	animation.onfinish = removeParticle;
}
function removeParticle(e) {
	e.srcElement.effect.target.remove();
}
