-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kurssi(
	kurssi_id SERIAL PRIMARY KEY,
	nimi varchar(60) NOT NULL,
	opintopisteet smallint NOT NULL,
	kuvaus text
);

CREATE TABLE Oppilas(
	opiskelijanumero SERIAL PRIMARY KEY,
	etunimi varchar(30) NOT NULL,
	sukunimi varchar(30) NOT NULL,
	opintopisteet smallint DEFAULT 0,
	password varchar(50) NOT NULL
);

CREATE TABLE Opettaja(
        opettajatunnus SERIAL PRIMARY KEY,
        etunimi varchar(30) NOT NULL,
        sukunimi varchar(30) NOT NULL,
        admin boolean DEFAULT false,
        password varchar(50) NOT NULL
);

CREATE TABLE Toteutus(
	tote_id SERIAL PRIMARY KEY,
	periodi smallint NOT NULL,
	alkupvm date NOT NULL,
	koepvm date,
	info text,
	vastuu_id integer REFERENCES Opettaja(opettajatunnus) ON DELETE CASCADE,
	kurssi_id integer REFERENCES Kurssi(kurssi_id) ON DELETE CASCADE
);

CREATE TABLE Suoritus(
	pvm date NOT NULL,
	arvosana smallint NOT NULL,
	tote_id integer REFERENCES Toteutus(tote_id) ON DELETE CASCADE,
	suorittaja integer REFERENCES Oppilas(opiskelijanumero) ON DELETE CASCADE,
	PRIMARY KEY (tote_id, suorittaja)
);

CREATE TABLE Ilmoittautuminen(
	ilmoaika timestamp DEFAULT NOW(),
	tote_id integer REFERENCES Toteutus(tote_id) ON DELETE CASCADE,
        ilmoittautuja integer REFERENCES Oppilas(opiskelijanumero) ON DELETE CASCADE,
	PRIMARY KEY (ilmoittautuja, tote_id)
);
