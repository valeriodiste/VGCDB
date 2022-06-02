
/* Aggiusta il testo nel "textSelector" all'interno del suo container:
	- maxFontSize: massima size della stringa (in pixels) nel textSelector (quandon il testo ha textLength <= relativeMinTextLength)
	- relativeMaxTextLength: massimo numero di caratteri visualizzabili nel container quando il testo ha dimensione "maxFontSize"
	- minFontSize: minima size della stringa (in pixels) nel textSelector (quandon il testo ha textLength >= relativeMaxTextLength)
	- relativeMaxTextLength: minimo numero di caratteri visualizzabili nel container quando il testo ha dimensione "minFontSize"
*/
function fitText(textSelector, relativeMinTextLength, relativeMaxTextLength, minFontSize, maxFontSize) { 

		$(textSelector).each(function() {
			let text = $(this).text().trim().trim('\t');
			let charLength = ClampValue(parseFloat(text.length), relativeMinTextLength, relativeMaxTextLength);

			let lenMin = parseFloat(relativeMinTextLength);
			let lenMax = parseFloat(relativeMaxTextLength);
			
			function f(x) {
				let p1 = lenMax - lenMin;
				let p2 = lenMin;
				let p3 = parseFloat(minFontSize);
				let p4 = parseFloat(maxFontSize) - parseFloat(minFontSize);

				// Funzione parabolica: ( a * X^2 ) + ( b * X ) + C
				let v = ((x * 14.0 / p1) + 8.0 - p2);
				return (((((0.181278) * v * v) - ((8.20085) * v) + (118.808 - 26.12)) * p4) / 38.683) + p3;	
			}

			quadraticFontSize = f(charLength);
			$(this).css("font-size",`${quadraticFontSize}px`);
		});
}


$(document).ready(function () {
	fitAllText();
});


function fitAllText() {
	
	fitText(".character-name > h2", 8, 22, 25, 66);
	fitText(".character-series > p > a", (8 + 8), (8 + 25), 18, 31.8);		// the 8 in "(8 + 8) takes into consideration the number of added characters due to the "from: " and the " >"

	fitText(".vertical-character-card > div > div > a", 10, 22, 18.5, 36);
	fitText(".vertical-character-card > div > div > p", 14, 25, 17.2, 27.6);

	fitText(".horizontal-character-card > div > div > div > a", 8, 22, 15.8, 39);
	fitText(".horizontal-character-card > div > div > div > p", 13, 25, 14.8, 34);

}

// Funzione utile a calcolare la minSize e maxSize per i campi testuali su cui usare "fitText()"
function calculateFontMinMaxSizes(textSelector, setSize = -1) {
	if (document.querySelector(textSelector)) {
		let texts = document.querySelectorAll(textSelector);
		for (i = 0; i < texts.length; i++) {
			let textElement = texts[i];
			let fontsizeString = window.getComputedStyle(textElement, null).getPropertyValue('font-size');
			if (setSize != -1) {
				textElement.style.fontSize = `${setSize}px`;
			}
		}
	}
}

