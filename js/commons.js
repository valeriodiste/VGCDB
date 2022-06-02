
function ClampNormalize(num, min, max, norm_min, norm_max) {
	n = num;
	if (num > max) n = max;
	else if (num < min) n = min;
	new_value = (norm_max - norm_min) / (max - min) * (n - min) + norm_min;
	return new_value
}

function ClampValue(value, min, max) {
	if (value > max) {
		return max;
	}
	if (value < min) {
		return min;
	}
	return value;
}

function ClickOnVerticalCharacterCards() {

	/* Click on vertical character card */
	document.querySelectorAll(".vertical-character-card").forEach( function (element) {
		element.addEventListener("click", (e) => {
			let url = e.target.querySelector("div > div > a").href;
			if (url[0] == 'j') {
				let real_url_str = url.slice(25, -2);
				let real_url = decodeURIComponent(real_url_str);
				window["transitionTo"](real_url);
			} else {
				let real_url = decodeURIComponent(url);
				// console.log("redirecting to: " + real_url);
				window.location.href = real_url;
			}
		})
	});

}

function ClickOnHorizontalCharacterCards() {

	/* Click on horizontal character card */
	document.querySelectorAll(".horizontal-character-card").forEach( function (element) {
		element.addEventListener("click", (e) => {
			let url = e.target.querySelector("div > div > div > a").href;
			if (url[0] == 'j') {
				let real_url_str = url.slice(25, -2);
				let real_url = decodeURIComponent(real_url_str);
				window["transitionTo"](real_url);
			} else {
				let real_url = decodeURIComponent(url);
				window.location.href = real_url;
			}
		})
	});

}

$(document).ready( function() {

	ClickOnVerticalCharacterCards();

	ClickOnHorizontalCharacterCards();

});
