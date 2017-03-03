CREATE TABLE Kayttaja(
        id SERIAL PRIMARY KEY,
        username varchar(61) NOT NULL,
        password varchar(50) NOT NULL,
        teacher boolean NOT NULL,
        admin boolean DEFAULT false
);

CREATE TABLE Oppilas(
	etunimi varchar(30) NOT NULL,
	sukunimi varchar(30) NOT NULL,
	opintopisteet smallint DEFAULT 0,
	opiskelijanumero integer REFERENCES Kayttaja(id) ON DELETE CASCADE,
        PRIMARY KEY(opiskelijanumero)
);

CREATE TABLE Opettaja(
        etunimi varchar(30) NOT NULL,
        sukunimi varchar(30) NOT NULL,
        admin boolean DEFAULT false,
        opettajatunnus integer REFERENCES Kayttaja(id) ON DELETE CASCADE,
        PRIMARY KEY(opettajatunnus)
);

CREATE TABLE Kurssi(
	kurssi_id SERIAL PRIMARY KEY,
	nimi varchar(60) NOT NULL,
	opintopisteet smallint NOT NULL,
	kuvaus text
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