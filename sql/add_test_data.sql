-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kurssi(nimi, opintopisteet, kuvaus) 
VALUES ('Linis 1', 5, 'Matikkaa');
INSERT INTO Oppilas(etunimi, sukunimi, opintopisteet, password)
VALUES ('Matti', 'Niemi', 145, 'hunter2');
INSERT INTO Opettaja(etunimi, sukunimi, admin, password) 
VALUES ('Lotta', 'Suominen', false, 'salakala');
INSERT INTO Toteutus(periodi, alkupvm, info, vastuu_id, kurssi_id) 
VALUES (2, NOW(), 'Paha kurssi', (SELECT opettajatunnus from Opettaja WHERE sukunimi='Suominen'), 
(SELECT kurssi_id from Kurssi WHERE nimi='Linis 1')) ;
INSERT INTO Ilmoittautuminen(tote_id, ilmoittautuja) 
VALUES ((SELECT tote_id from Toteutus WHERE periodi=2), (SELECT opiskelijanumero from Oppilas WHERE etunimi='Matti'));
INSERT INTO Suoritus(pvm, arvosana, tote_id, suorittaja) 
VALUES (NOW(), 4, (SELECT tote_id from Toteutus WHERE periodi=2), (SELECT opiskelijanumero from Oppilas WHERE etunimi='Matti'));

