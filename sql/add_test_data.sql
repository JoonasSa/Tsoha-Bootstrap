-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja(username, password, admin, teacher)
VALUES ('Testi Jäbä', 'salasana', true, true), ('Lotta Suominen', 'salakala', false, true), ('Hermanni Pallovasara', 'spurdo', false, true),
('Matti Niemi', 'hunter2', false, false), ('Pekka Mutka', 'spooky123', false, false);

INSERT INTO Kurssi(nimi, opintopisteet, kuvaus) 
VALUES ('Linis 1', 5, 'Matikkaa'),
('Logiikka 1', 4, 'Aika loogista'),
('Logiikka 2', 5, 'Loogisempaa'),
('Logiikka 5.3', 8, 'Loogisin');

INSERT INTO Opettaja(etunimi, sukunimi, admin, opettajatunnus) 
VALUES ('Testi', 'Jäbä', true, 1),
('Lotta', 'Suominen', false, 2),
('Hermanni', 'Pallovasara', true, 3);

INSERT INTO Oppilas(etunimi, sukunimi, opintopisteet, opiskelijanumero)
VALUES ('Matti', 'Niemi', 145, 4),
('Pekka', 'Mutka', 17, 5);

INSERT INTO Toteutus(periodi, alkupvm, info, vastuu_id, kurssi_id) 
VALUES (2, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 1, 1),
(3, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 2, 2),
(4, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 1, 2),
(1, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 2, 1),
(2, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 2, 1);

INSERT INTO Ilmoittautuminen(tote_id, ilmoittautuja) 
VALUES (1, 4), (2, 4), (2, 5), (4, 5), (3, 4), (5, 5), (5, 4);

INSERT INTO Suoritus(pvm, arvosana, tote_id, suorittaja) 
VALUES (NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 4, 1, 5),
(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 1, 1, 4),
(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 5, 3, 5);

