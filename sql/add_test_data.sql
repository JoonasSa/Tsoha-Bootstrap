-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja(username)
VALUES ('Testi Jäbä');

INSERT INTO Kurssi(nimi, opintopisteet, kuvaus) 
VALUES ('Linis 1', 5, 'Matikkaa'),
('Logiikka 1', 4, 'Aika loogista'),
('Logiikka 2', 5, 'Loogisempaa'),
('Logiikka 5.3', 8, 'Loogisin');

INSERT INTO Oppilas(etunimi, sukunimi, opintopisteet, password)
VALUES ('Matti', 'Niemi', 145, 'hunter2'),
('Pekka', 'Mutka', 17, 'salasana');

INSERT INTO Opettaja(etunimi, sukunimi, admin, password) 
VALUES ('Testi', 'Jäbä', true, 'salasana'),
('Lotta', 'Suominen', false, 'salakala'),
('Hermanni', 'Pallovasara', true, 'spooky123');

INSERT INTO Toteutus(periodi, alkupvm, info, vastuu_id, kurssi_id) 
VALUES (2, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 1, 1),
(3, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 2, 2),
(4, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 1, 2),
(1, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 2, 1),
(2, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 2, 1);

INSERT INTO Ilmoittautuminen(tote_id, ilmoittautuja) 
VALUES (1, 2), (2, 2), (2, 1), (4, 1), (3, 1), (5, 2), (5, 1);

INSERT INTO Suoritus(pvm, arvosana, tote_id, suorittaja) 
VALUES (NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 4, 1, 1),
(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 1, 1, 2),
(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 5, 3, 1);

