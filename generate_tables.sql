-- FILE DA UTILIZZARE PER GENERARE IL DATABASE DEL SITO (O ALMENO LE TABELLE, VUOTE NECESSARIE AL SUO FUNZIONAMENTO)
-- Eseguire questo file sql in un database relazionale postgres 
-- La password del database da eseguire dovrebbe essere "vgcdb" per permettere al sito di connettersi a tale database 
--		(altrimenti è possibile cambiare la passwod per le query PHP di connessione al database, SCONSIGLIATO per evitare problemi)
-- Pe eseguire correttamente il file seguente, ed importare la tabella dei personaggi nel database, occorre utilizzare il file 
--		vgcdb_characters_data.csv allegato alla repository, settando l'opportuno percorso del file nella query COPY FROM alla fine di questo script


DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
	username varchar(20) primary key,
	password varchar(32),
	icon varchar(20)
);

DROP TABLE IF EXISTS favourites;
CREATE TABLE IF NOT EXISTS favourites (
	username varchar(20),
	character varchar(22),
	universe varchar(25),

	primary key(username, character, universe)
);

DROP TABLE IF EXISTS suggestions;
CREATE TABLE IF NOT EXISTS suggestions (
	username varchar(20),
	character varchar(22),
	universe varchar(25),
	year int,
	eye varchar(16),
	hair varchar(16),
	role varchar(11),
	gender varchar(6),
	notes varchar(5000),
	primary key(username, character, universe)
);

DROP TABLE IF EXISTS characters;
CREATE TABLE IF NOT EXISTS characters (
	formatted_name varchar(22),
	formatted_universe varchar(25),
	year int,
	role varchar(11),
	gender varchar(6),
	eye varchar(16),
	hair varchar(16),
	color1 varchar(10),
	color2 varchar(10),
	description varchar(50000),
	image varchar(60),
	banner varchar(60),
	name varchar(22),
	universe varchar(25),

	primary key (name, universe)
);

----------------------------------------- Import from CSV ---------------------------------------------------------------------------

-- Il codice seguente importa i dati dal file vgcdb_characters_data.csv selezionato all'interno della tabella characters
-- Se il file non può essere letto (permission denied), seguire la guida alla pagina https://stackoverflow.com/questions/14083311/permission-denied-when-trying-to-import-a-csv-file-from-pgadmin
--		in particolare seguire il procedimento della prima risposta (settaggio dei permessi del file per "Everyone")
-- 		Il procedimento, in generale, per risolvere l'errore di "permission denied", su WINDOWS, è il seguente:
--		>	Aprire le proprietà del file vgcdb_characters_data.csv
--		>	Andare in:
--				Sicurezza > Avanzate > Aggiungi > Seleziona un'entità
--		> Inserire, nella casella di testo, la stringa "Everyone" (senza virgolette)
--		> Premere "Ok" e poi di nuovo "Ok"
--		> Uscire dalle proprietà del file (fine)


-- COPIA per la tabella characters ######################################################################
TRUNCATE TABLE characters;	-- Elimina la tabella prima di copiarla	
COPY characters
FROM 'C:\[% PERCORSO_DEL_FILE_CSV %]\vgcdb_characters_data.csv'			-- Percorso del file csv da importare ==============================================================================
DELIMITER ','
CSV Header;

-- Query che mostra i personaggi del database ordinati in base all'importanza dei personaggi per ogni universo (se tutto va a buon fine si deve visualizzare la tabella dei personaggi)
SELECT formatted_name,name,formatted_universe,universe,year,role,gender,eye,hair,color1,color2,description
FROM characters 
ORDER BY universe, LENGTH(role) DESC, name;		

