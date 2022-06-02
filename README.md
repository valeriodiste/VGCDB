<h3>VGCDB: Video Game Characters DataBase</h3>

> Sito web di informazioni su personaggi dei videogiochi di vari universi (o serie / franchises).


**Tecnologie utilizzate**

- HTML (lato client)
- CSS (fogli di stile)
- JavaScript (scripting)
- PHP (lato server)
- AJAX (+ PHP) (per la comunicazione asincrona col server per risultati di ricerca e aggiunta di un personaggio ai preferiti)
- postgreSQL (+ SQL & pgAdmin) (gestione database relazionale)

**Librerie esterne:**
- JQuery (scripting)
- Three.js (visualizzazione della grafica 3D e delle relative animazioni nella homepage del sito)

**Strumenti aggiuntivi:**

- Blender (software di grafica 3D per il "modelling" del personaggio 3D "Super Mario" e delle relative animazioni, del rigging, del texturing, ecc…)
- Adobe Illustrator (design iniziale delle pagine / mockup, manipolazione immagini, manipolazione SVG e creazione di icone apposite per gli elementi del sito)
- Google Fogli (manipolazione e creazione dei dati dei personaggi del database, poi importati nel database come CSV)
- Wikipedia (fonte informazioni dei personaggi del database)


**Componenti del gruppo**

Valerio Di Stefano (matricola 1898728)

Giuseppe Prisco (matricola 1895709)

**Descrizione funzionalità generali del sito**

Il sito permette la ricerca di personaggi per nome ed altri filtri aggiuntivi (nome, universo di appartenenza, anno di prima apparizione, ruolo nel videogioco di appartenenza, sesso, colore dei capelli e colore degli occhi) dalle pagine di Advanced Search, dalla HomePage (utilizzando la barra di ricerca per nome del personaggio) e Results Page (utilizzando i filtri laterali).

Sul form dei filtri di ricerca dei personaggi sono stati effettuati vari controlli di integrità dei dati e rispetto del formato richiesto (vari controlli sul range dell’anno di prima apparizione del personaggio).

I personaggi e le informazioni su di essi sono salvati in un database relazionale (locale) postgres gestito con postgreSQL.

Il sito permette di visualizzare informazioni su un personaggio in una pagina dedicata (nome, universo di appartenenza, descrizione, immagini del personaggio e del banner, anno di prima apparizione, ruolo nel videogioco di appartenenza, sesso, colore dei capelli e colore degli occhi) e i personaggi ad esso correlati (personaggi di uno stesso universo).

Il sito permette inoltre di effettuare la registrazione ed il login con uno user account (con personalizzazione del nome utente e dell’immagine del profilo), per poter aggiungere un personaggio ai preferiti (dalla pagina di visualizzazione delle immagini del personaggio) e suggerire l’aggiunta di un personaggio al database del sito. 

Sul form di registrazione sono stati effettuati vari controlli di integrità dei dati e rispetto del formato richiesto (controllo della disponibilità dello username nel sito, controllo del formato della password con espressioni regolari).

Anche sul form di login sono stati effettuati vari controlli di integrità dei dati (controllo dell’esistenza dello username nel sito, controllo del formato della correttezza della password dell’utente).

I dati dell’utente sono salvati nel database (in maniera criptata) e il controllo dell’accesso dell’utente è effettuato mediante session storage (sul server, tramite PHP).

La pagina del profilo dell’utente consente di visualizzare le informazioni dell’utente attualmente “loggato” nel sito, quali username, icona del profilo, numero di personaggi aggiunti ai preferiti e relativa lista dei personaggi preferiti, numero di personaggi suggeriti al sito.

Nel sito è presente la possibilità di attivare/disattivare le animazioni di transizione delle pagine e di attivare/disattivare la “modalità scura” per il sito: le 2 opzioni sono visualizzate nella barra del menu e gestite attraverso local storage del browser.

Tutte le pagine del sito sono responsive: sono stati utilizzati i soli CSS del sito per la gestione della responsiveness di tutte le pagine (non è stata utilizzata la libreria Bootstrap, per poter personalizzare gli stili, le animazioni ed i controlli del sito il più possibile), in particolare utilizzando varie media queries in tutte le pagine, flexbox e grid con relativa ridisposizione del layout delle pagine.

I fogli di stile CSS sono stati utilizzati anche per la realizzazione di varie animazioni del sito (oltre alle più semplici, quali l’animazione di transizione tra una pagina e l’altra e le animazioni di interazione con bottoni, checkboxes, card cliccabili, link, ecc…, sono stati utilizzati gli stili CSS anche per le animazioni più complesse come l’animazione del “loader” dell’homepage, l’animazione di “pop” delle stelle per l’aggiunta del personaggio ai preferiti, l’animazione di comparsa, scomparsa e gestione dei controlli di password e altri campi del form, ecc…).

Javascript è stato utilizzato, oltre che per effettuare vari controlli dei dati immessi nei vari form del sito, anche per il controllo dei comportamenti dei vari elementi del sito all’interazione con l’utente (insieme alle animazioni dei fogli di stile CSS, ad esempio per l’animazione di transizione tra le pagine del sito), e per il controllo della visualizzazione di aspetti dinamici del sito (aggiustamento della dimensione del font dei nomi dei personaggi nelle varie pagine PHP, quindi con contenuti dinamici, del sito, comparsa e controllo delle animazioni e delle funzioni della barra di navigazione, gestione del dropdown degli universi presenti nel sito nelle sezioni di ricerca dei personaggi, in base all’input dell’utente, ecc…).

Javascript, insieme alla libreria esterna Three.js, è stato utilizzato per controllare il caricamento, la visualizzazione, e tutti gli altri aspetti relativi al modello 3D visualizzato nella HomePage, così come per le animazioni di interazione con l’utente (animazione di “follow” del puntatore dell’utente, animazione di “saluto” verso l’utente al click sul modello 3D).



