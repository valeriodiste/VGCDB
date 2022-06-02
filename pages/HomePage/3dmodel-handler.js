let frameHandler, everythingSet;

let scene, 								// Scena 3D da renderizzare
	renderer,							// Renderer per la scena 3D (renderizza la scena)
	camera,								// "Camera" per visualizzare la scena 3D
	mario,								// Modello 3D di Mario
	neck,								// Reference alla "neck bone" di Mario
	waist,                              // Reference alla "waist bone" di Mario
	clickArea,							// ClickArea per il trigger della "Wave Animation"
	plane,								// Piano "invisibile" per il cast della shadow di Mario
	mixer,                              // Animation mixer di THREE.js
	idle,                               // Idle Animation, "stato" di default di Mario
	wave,                               // Wave Animation, animazione riprodotta dopo il click su Mario
	waveAnim,							// Wave animation clip
	clock = new THREE.Clock(),          // Usato dalle animazioni (anims) per controllare il tempo (viene utilizzato un "clock" e NON il "frame rate")
	currentlyAnimating = false,         // Vale "true" se la "Wave Animation" è attiva (cioè se la "neck bone" di Mario è in uso nella "Wave Animation")
	raycaster = new THREE.Raycaster(),  // Usato per controllare se si clicca su Mario (o meglio, sulla "trigger-box" posta davanti Mario)
	playFollowMouseAnimation = false,	// Controlla se Mario segue o no il mouse con lo sguardo
	loaderAnim = document.getElementById('loader-animation');	// Loader Animation che compare nonappena la pagina viene caricata

const degreeLimit = 20;		// Controlla di quanto Mario segue il mouse con lo sguardo

// Variabili per l'animazione di "follow mouse" di Mario
var xMousePosTo = 0,
	yMousePosTo = 0,
	catchUpWithMouseSpeed = 0.62,
	xCaughtUpWithMouse = false,
	yCaughtUpWithMouse = false;

scene = new THREE.Scene();
scene.background = new THREE.Color(0xff0000);	// Setta il background ad un colore (red)
scene.background = null;						// Setta il background come "trasparente" (no background)

const canvas = document.getElementById('render-canvas');

const aspect = canvas.width / canvas.height;
camera = new THREE.PerspectiveCamera(50, aspect, 0.05, 5000);
camera.position.set(0, 8.5, 30);

renderer = new THREE.WebGLRenderer({
	canvas, 							// Il canvas (con ID "render-canvas") all'interno del quale la scena viene renderizzata
	antialias: true, 					// Antialias (rende l'immagine renderizzata più "nitida")
	alpha: true, 						// Fa in modo che il background possa essere "trasparente"
	pixelRatio: window.devicePixelRatio,
	outputEncoding: THREE.sRGBEncoding	// Pixel ratio del renderer (uguale al pixel ratio della finestra di visualizzazione della pagina web)
});
renderer.shadowMap.enabled = true;
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.toneMapping = THREE.ReinhardToneMapping;
renderer.toneMappingExposure = 2.3;

// Rende il canvas "responsive" al cambio di dimensione della finestra di visualizzazione
function ResizeRenderer() {
	if (resizeRendererToDisplaySize(renderer)) {
		var marioPosX = (camera.position.z * (camera.fov * camera.aspect / 2)) / 100;
		SetMarioPosition(marioPosX, 1);
		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();
	}
}

// Restituisce true se occorre effettuare il resize del renderer
function resizeRendererToDisplaySize(renderer) {
	const width = window.innerWidth;
	const height = window.innerHeight;
	const needResize = canvas.innerWidth != width || canvas.innerHeight != height;
	if (needResize) {
		renderer.setSize(width, height, true);
	}
	return needResize;
}

// Setta la posizione del modello 3D di Mario (e con esso, l'hitbox della ClickArea, ecc...)
function SetMarioPosition(x, y) {
	if (mario && clickArea) {
		// Aggiusta la posizione di Mario
		mario.position.x = x;
		mario.position.y = y;

		// Aggiusta la posizione della ClickArea
		clickArea.position.x = x;
		clickArea.position.y = y + 8;

		// Aggiusta la posizione del "floor"
		plane.position.x = x;
		plane.position.y = y;

		// Aggiusta la rotazione di Mario e della ClickArea in base alla posizione
		const marioPosLimitForRotation = 70;
		if (mario.position.x <= marioPosLimitForRotation) {
			mario.rotation.y = -1 * mario.position.x / camera.position.z;
			clickArea.rotation.y = -1 * clickArea.position.x / camera.position.z;
		}
	} else {	// Se il modello di mario oppure la clickArea non sono ancora stati caricati...
		// Aspetta 100 millisecondi (in modo asincrono, cioè l'esecuzione del resto del codice continua a progredire)
		//		 e poi prova ad eseguire di nuovo la funzione SetMarioPosition(x,y)
		setTimeout(SetMarioPosition, 100, x, y);
	}
}

// Aggiunge luci alla scena 3D
function addSceneLights() {

	// Ambient Light
	let ambientLight = new THREE.AmbientLight(0xffffff, 0.35);
	scene.add(ambientLight);

	// Hemisphere Light
	let hemiLight = new THREE.HemisphereLight(0xffeeb1, 0x080820, 3.4);
	scene.add(hemiLight);

	// Spot Light (Sun)
	let spotLight = new THREE.SpotLight(0xffa95c, 3.5);
	spotLight.castShadow = true;
	spotLight.shadow.bias = -0.000001;
	spotLight.shadow.mapSize.width = 1024 * 4;
	spotLight.shadow.mapSize.height = 1024 * 4;
	spotLight.position.set(
		camera.position.x + 5,
		camera.position.y + 80,
		camera.position.z + 30
	);
	scene.add(spotLight);

	// Point Light
	let pointLight = new THREE.PointLight(0xffffff, 1.35);
	pointLight.position.set(-15, 100, 30);
	scene.add(pointLight);
}
addSceneLights();

// "Loader" per caricare il modello 3D di Mario nella scena
const loader = new THREE.GLTFLoader();
loader.load(
	'3D/mario.gltf',	// Modello 3D da caricare
	function (gltf) {	// Funcione di "callback" eseguita una volta completato il caricamento del modello
		mario = gltf.scene;
		let fileAnimations = gltf.animations;

		mario.traverse(o => {

			if (o.isMesh) {

				o.castShadow = true;
				o.receiveShadow = true;

				if (o.material) {

					o.material.map.anisotropy = 16;

					o.material.side = THREE.FrontSide;
					o.material.shadowSide = THREE.BackSide;

					var prevMaterial = o.material;
					var newMaterial = new THREE.MeshPhysicalMaterial(prevMaterial);
					o.material = newMaterial;

					// Settaggio delle proprietà di "roughness" e "metalness" dei materials delle parti del corpo di Mario (oltre che della sheen)
					if (o.name === 'blue_suit') {
						o.material.sheen = new THREE.Color(0.1, 0.1, 0.1);
						o.material.metalness = 0;
						o.material.roughness = 0.9;
					} else if (o.name === 'buttons') {
						o.material.metalness = 0.2;
						o.material.roughness = 0.5;
					} else if (o.name === 'face' || o.name === 'ears') {
						o.material.sheen = new THREE.Color(0.12, 0.12, 0.12);
						o.material.metalness = 0;
						o.material.roughness = 0.85;
					} else if (o.name === 'gloves') {
						o.material.sheen = new THREE.Color(0.05, 0.05, 0.05);
						o.material.metalness = 0;
						o.material.roughness = 0;
					} else if (o.name === 'hair') {
						o.material.sheen = new THREE.Color(0.12, 0.12, 0.12);
						o.material.metalness = 0;
						o.material.roughness = 0.7;
					} else if (o.name === 'mustaches') {
						o.material.sheen = new THREE.Color(0.1, 0.1, 0.1);
						o.material.metalness = 0;
						o.material.roughness = 0.7;
					} else if (o.name === 'red_shirt' || o.name === 'cap') {
						o.material.sheen = new THREE.Color(0.2, 0.2, 0.2);
						o.material.metalness = 0;
						o.material.roughness = 0.2;
					} else if (o.name === 'shoes') {
						o.material.metalness = 0.15;
						o.material.roughness = 0.5;
					}
				}
			}

			// References per la "neck" e la "waist" bones
			if (o.isBone) {
				if (o.name === 'rigNeck')
					neck = o;
				else if (o.name === 'rigSpine')
					waist = o;

			}
		});

		mario.scale.set(1.07, 1.07, 1.07);

		scene.add(mario);

		mixer = new THREE.AnimationMixer(mario);
		mixer.antialias = true;
		let idleAnim = THREE.AnimationClip.findByName(fileAnimations, 'idle');
		idleAnim.tracks.splice(3, 3);
		idleAnim.tracks.splice(9, 3);
		idle = mixer.clipAction(idleAnim);

		idle.play();

		waveAnim = THREE.AnimationClip.findByName(fileAnimations, 'wave');
		waveAnim.tracks.splice(3, 3);
		waveAnim.tracks.splice(9, 3);
		wave = mixer.clipAction(waveAnim);

		EverythingLoaded();
	},
	undefined,			// Non c'è bisogno di questa funzione
	function (error) {	// Funzione eseguita in caso di errore
		console.error(error);
	}
);

// Rimuove il loader dalla pagina (se il modello 3D e gli altri oggetti sono stati correttamente caricati), e esegue altre azioni iniziali
function EverythingLoaded() {
	if (clock.elapsedTime > 1.2 && mario && clickArea && plane && !everythingSet && !playFollowMouseAnimation) {
		document.querySelectorAll("#menu-bar > .menu-icons > div").forEach( function(element) { 
			element.style.animation = "opacity-in 0.45s forwards";
		} );
		if (document.querySelector("#loader-animation")) {
			document.querySelector("html").style.animation = "loaded-body-background 0.2s forwards";
			document.querySelector("#loader-animation").style.animation = "loaded-translate 0.8s 0.1s forwards";
			document.querySelector(".loader-wrapper").style.animation = "loaded-blur 0.5s forwards";
			document.querySelector("html").style.overflowY = "visible";
			setTimeout(function () { loaderAnim.remove(); }, 6000);
		}
		setTimeout(() => {
			playModifierAnimation(idle, 0.25, wave, 0.25);
			setTimeout(() => {
				playFollowMouseAnimation = true;
			}, wave._clip.duration * 1000 - ((0.25 + 0.25) * 1000)
			);
		}, 500);
		everythingSet = true;
	} else if (!everythingSet && !playFollowMouseAnimation) {	// Se il modello di mario oppure la clickArea non sono ancora stati caricati...
		if (mario && neck && waist) {
			InitializeJointsPosition();
		}
		// Aspetta 500 millisecondi (in modo asincrono, cioè l'esecuzione del resto del codice continua a progredire)
		//		 e poi prova ad eseguire di nuovo la funzione EverythingLoaded()
		setTimeout(EverythingLoaded, 500);
	}
}

// "Floor" che riceve l'ombra proiettata da Mario (sotto Mario)
function FloorForShadow() {
	let floorGeometry = new THREE.PlaneGeometry(1000, 200);
	let floorMaterial = new THREE.ShadowMaterial();
	floorMaterial.opacity = 0.1;
	plane = new THREE.Mesh(floorGeometry, floorMaterial);
	plane.receiveShadow = true;
	floorGeometry.rotateX(- Math.PI / 2);
	scene.add(plane);
}
FloorForShadow();

// Aggiunge la ClickArea per il trigger della "Wave Animation"
function ClickArea() {
	let clickAreaGeometry = new THREE.CubeGeometry(5, 15, 5.5);
	let clickAreaMaterial = new THREE.MeshBasicMaterial({ color: 0xffffff, wireframe: true })
	clickAreaMaterial.visible = false;	// Setta a "true" per mostrare la ClickArea
	clickArea = new THREE.Mesh(clickAreaGeometry, clickAreaMaterial);

	clickArea.position.y = 8;
	clickArea.position.z = 0;
	clickArea.name = "ClickArea";
	scene.add(clickArea);
}
ClickArea();

// Sfuma dalla "from" animation (con velocità fSpeed) alla "to" animation (con velocità "tSpeed")
function playModifierAnimation(from, fSpeed, to, tSpeed) {
	to.setLoop(THREE.LoopOnce);
	to.reset();
	to.play();
	from.crossFadeTo(to, fSpeed, true);
	setTimeout(function () {
		from.enabled = true;
		to.crossFadeTo(from, tSpeed, true);
		currentlyAnimating = false;
	}, to._clip.duration * 1000 - ((tSpeed + fSpeed) * 1000));
}

// Attiva la "Wave Animation" di Mario al click del mouse
function WaveOnClick() {

	window.addEventListener('click', e => raycast(e));
	window.addEventListener('touched', e => raycast(e, true));

	function playOnClick() {
		playModifierAnimation(idle, 0.25, wave, 0.25);
	}

	function raycast(e, touch = false) {
		var mouse = {};
		if (touch) {
			mouse.x = 2 * (e.changedTouches[0].clientX / window.innerWidth) - 1;
			mouse.y = 1 - 2 * (e.changedTouches[0].clientY / window.innerHeight);
		} else {
			mouse.x = 2 * (e.clientX / window.innerWidth) - 1;
			mouse.y = 1 - 2 * (e.clientY / window.innerHeight);
		}
		raycaster.setFromCamera(mouse, camera);

		var intersects = raycaster.intersectObjects(scene.children, true);

		if (intersects[0]) {
			var object = intersects[0].object;
			if (object.name == "ClickArea") {
				if (!currentlyAnimating) {
					currentlyAnimating = true;
					playOnClick();
				}
			}
		}
	}
}
WaveOnClick();

// Inizializza la rotazione dei joints "neck" e "waist"
function InitializeJointsPosition() {

	offset = GetMouseOffset();
	var mouseXOffset = offset.x * -2.5;
	var mouseYOffset = offset.y * 3.5;

	xMousePosTo = mouseXOffset;
	yMousePosTo = mouseYOffset;

	const coords = { x: xMousePosTo, y: yMousePosTo };
	moveJoint(coords, neck, degreeLimit);
	moveJoint(coords, waist, degreeLimit);
}


// Ruota il joint verso la posizione di "posCoords"
function moveJoint(posCoords, joint, degreeLimit) {
	let degrees = getMouseDegrees(posCoords.x, posCoords.y, degreeLimit);
	joint.rotation.y = THREE.Math.degToRad(degrees.x);
	joint.rotation.x = THREE.Math.degToRad(degrees.y);
}

// Restituisce una rotazione {x,y} rispetto alle posizioni x e y passate come parametri
function getMouseDegrees(x, y, degreeLimit) {
	let dx = 0,
		dy = 0,
		xdiff,
		xPercentage,
		ydiff,
		yPercentage;

	let w = { x: window.innerWidth, y: window.innerHeight };


	if (x <= w.x / 2) {
		xdiff = w.x / 2 - x;
		xPercentage = (xdiff / (w.x / 2)) * 100;
		dx = ((degreeLimit * xPercentage) / 100) * -1;
	}
	if (x >= w.x / 2) {
		xdiff = x - w.x / 2;
		xPercentage = (xdiff / (w.x / 2)) * 100;
		dx = (degreeLimit * xPercentage) / 100;
	}
	if (y <= w.y / 2) {
		ydiff = w.y / 2 - y;
		yPercentage = (ydiff / (w.y / 2)) * 100;
		dy = (((degreeLimit * 0.5) * yPercentage) / 100) * -1;
	}
	if (y >= w.y / 2) {
		ydiff = y - w.y / 2;
		yPercentage = (ydiff / (w.y / 2)) * 100;
		dy = (degreeLimit * yPercentage) / 100;
	}
	return { x: dx, y: dy };
}

// Restituisce l'offset per il mouse (per l'animazione "FollowMouse" di Mario)
function GetMouseOffset() {
	// Clamp e Normalize di num tra 0 e 1
	function ClampNormalize(num, min, max, norm_min, norm_max) {
		var n = num;
		if (num > max) n = max;
		else if (num < min) n = min;
		var new_value = (norm_max - norm_min) / (max - min) * (n - min) + norm_min;
		return new_value
	}
	// Calcola l'offset per lo sguardo di Mario
	var scrollElem = document.scrollingElement;
	var maxScroll = scrollElem.scrollHeight - document.documentElement.clientHeight;
	var dy = ClampNormalize(scrollElem.scrollTop, 0, maxScroll, 0, 1);
	var mouseXOffset = (-20 * mario.position.x);
	var mouseYOffset = 100 + dy * 50;
	return { x: mouseXOffset, y: mouseYOffset }
}

// Fa in modo che Mario segua il mouse con lo sguardo
function FollowMouse() {

	document.addEventListener('mousemove', function (e) {

		// Muove lo sguardo di mario verso il mouse
		if (mario && playFollowMouseAnimation) {

			offset = GetMouseOffset();
			var mouseXOffset = offset.x;
			var mouseYOffset = offset.y;

			var mousecoords = getMousePos(e, mouseXOffset, mouseYOffset);

			if (neck && waist) {
				moveJoint(mousecoords, neck, degreeLimit);
				moveJoint(mousecoords, waist, degreeLimit);
			}
		}
	});

	function getMousePos(e, xOffset, yOffset) {

		var destX = e.clientX + xOffset;
		var destY = e.clientY + yOffset;

		if (!xCaughtUpWithMouse || !yCaughtUpWithMouse) {


			const xCheck = Math.abs(destX - xMousePosTo) >= Math.abs(destX) * catchUpWithMouseSpeed;
			const yCheck = Math.abs(destY - yMousePosTo) >= Math.abs(destY) * catchUpWithMouseSpeed;

			// x position
			if (xCheck && !xCaughtUpWithMouse) {

				const scaler = destX > xMousePosTo ? 1 : -1;
				xMousePosTo += scaler * (Math.abs(destX - xMousePosTo) + 10) * catchUpWithMouseSpeed;
			} else {
				xMousePosTo = destX;
				xCaughtUpWithMouse = true;
			}

			// y position
			if (yCheck && !yCaughtUpWithMouse) {
				const scaler = destY > yMousePosTo ? 1 : -1;
				yMousePosTo += scaler * (Math.abs(destY - yMousePosTo) + 10) * catchUpWithMouseSpeed;
			} else {
				yMousePosTo = destY;
				yCaughtUpWithMouse = true;
			}

			return { x: xMousePosTo, y: yMousePosTo };

		} else {
			return { x: destX, y: destY };
		}

	}
}
FollowMouse();

// Funzione di update (che viene eseguita ad ogni "frame")
function update() {

	// Update delle animazioni
	if (mixer) {
		mixer.update(clock.getDelta());
	}

	// Resize del renderer per la responsiveness della pagina
	ResizeRenderer();

	// Fa in modo che la funzione "update()" venga eseguita ad ogni frame (generalmente si hanno 60FPS, quindi esegue la funzione 60 volte al secondo)
	setTimeout( function() {
		frameHandler = requestAnimationFrame(update);
    }, 1000 / 45 );

	// Effettua l'update del renderer (e quindi della scena e della camera) ogni volta che la funzione "update()" viene eseguita (quindi ad ogni frame)
	renderer.render(scene, camera);

};
update();


$(document).ready( function() {

	// Setta la "scroll" position a "0" nonappena la pagina viene caricata
	$(window).scrollTop(0);

	if ($(window).width() <= 460 && $(".wrapper").css("display") != "none") {
		$(".wrapper").css("display", "none");
		
		cancelAnimationFrame(frameHandler);

		document.querySelectorAll("#menu-bar > .menu-icons > div").forEach( function(element) { 
			element.style.animation = "opacity-in 0.45s forwards";
		} );
		document.querySelector("html").style.animation = "loaded-body-background 0.2s forwards";
		document.querySelector("#body-wrapper > *:not(#loader-animation):not(#page-transition-in):not(#page-transition-out)").style.animation = "loaded-other-elements 0.2s forwards";
		document.querySelector("#loader-animation").style.animation = "loaded-translate 0.8s 0.1s forwards";
		document.querySelector(".loader-wrapper").style.animation = "loaded-blur 0.5s forwards";
		document.querySelector("html").style.overflowY = "visible";
		document.querySelector("#loader-animation").remove(); 

		playFollowMouseAnimation = true;

	} else if ($(window).width() > 460 && $(".wrapper").css("display") == "none") {
		$(".wrapper").css("display", "block");

		setTimeout(() => {
			document.querySelector("html").style.overflowY = "hidden";
		}, 200);

		requestAnimationFrame(update);
	}


});

$(window).on("resize", function() {
	if ($(window).width() <= 460 && $(".wrapper").css("display") != "none") {
		$(".wrapper").css("display", "none");
		cancelAnimationFrame(frameHandler);

	} else if ($(window).width() > 460 && $(".wrapper").css("display") == "none") {
		$(".wrapper").css("display", "block");

		requestAnimationFrame(update);
	}
});

