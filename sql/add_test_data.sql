-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kurssi(nimi, opintopisteet, kuvaus) 
VALUES ('Linis 1', 5, 'Matikkaa'),
('Logiikka 2', 5, 'Aika loogista');

INSERT INTO Oppilas(etunimi, sukunimi, opintopisteet, password)
VALUES ('Matti', 'Niemi', 145, 'hunter2'),
('Pekka', 'Mutka', 17, 'salasana');

INSERT INTO Opettaja(etunimi, sukunimi, admin, password) 
VALUES ('Lotta', 'Suominen', false, 'salakala'),
('Hermanni', 'Pallovasara', true, 'spooky123');

INSERT INTO Toteutus(periodi, alkupvm, info, vastuu_id, kurssi_id) 
VALUES (2, NOW(), 'Paha kurssi', (SELECT opettajatunnus FROM Opettaja WHERE sukunimi='Suominen'), (SELECT kurssi_id FROM Kurssi WHERE nimi='Linis 1'));

INSERT INTO Ilmoittautuminen(tote_id, ilmoittautuja) 
VALUES ((SELECT tote_id FROM Toteutus WHERE periodi=2), (SELECT opiskelijanumero FROM Oppilas WHERE etunimi='Matti'));

INSERT INTO Suoritus(pvm, arvosana, tote_id, suorittaja) 
VALUES (NOW(), 4, (SELECT tote_id FROM Toteutus WHERE periodi=2), (SELECT opiskelijanumero FROM Oppilas WHERE etunimi='Matti'));

