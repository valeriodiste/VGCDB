
// Gestione della session storage
if (typeof(Storage) !== "undefined") {
	
	if(typeof(sessionStorage.getItem("username")) === "undefined") {
		console.log("...");
		sessionStorage.setItem("username", "");
	}
	// if (!sessionStorage.darkMode) {
	// 	sessionStorage.setItem("darkMode", "false");
	// }
}

// Gestione del local storage
if (localStorage.getItem("pageTransitions") === null) {
	localStorage.setItem('pageTransitions', 'true');
};
if (localStorage.getItem("darkMode") === null) {
	localStorage.setItem('darkMode', 'false');
};
