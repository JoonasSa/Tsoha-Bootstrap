-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja(username, password, admin, teacher)
VALUES ('Testi Jäbä', 'salasana', true, true), ('Lotta Suominen', 'salakala', false, true), ('Hermanni Pallovasara', 'spurdo', false, true),
('Banjo', 'Kemppainen', false, true), ('Matti Niemi', 'hunter2', false, false), ('Pekka Mutka', 'spooky123', false, false),
('Vladimir', 'Putti', false, false), ('Björje', 'Burje', false, false), ('Viivi', 'Vatukka', false, false), ('Liisi', 'Riisipiisi', false, false);


INSERT INTO Kurssi(nimi, opintopisteet, kuvaus) 
VALUES ('Linis 1', 5, 'Vastaus joku hieno matriisi kuitenkin!'),
('Logiikka 1', 4, 'Aika loogista, yleensä...'),
('Logiikka 2', 5, 'Loogisempaa, mut vähän sekavaa silti.'),
('Tietokoneen toiminta', 5, 'Mites se kone oikein toimii?'),
('Tietoliikenteen perusteet', 6, 'Sähköinternet ja sen salat.'),
('Kuviokellunnan perusteet', 2, 'Elämäsi tilaisuus. Vain tosi kelluville.'),
('Mansikanpoiminta 3', 4, 'Viimeinen kurssi mansikanpoiminnan triossa.'),
('Bmur', 1, 'Klusterkole.');

INSERT INTO Opettaja(etunimi, sukunimi, admin, opettajatunnus) 
VALUES ('Testi', 'Jäbä', true, 1),
('Lotta', 'Suominen', false, 2),
('Hermanni', 'Pallovasara', true, 3),
('Banjo', 'Kemppainen', false, 4);

INSERT INTO Oppilas(etunimi, sukunimi, opintopisteet, opiskelijanumero)
VALUES ('Matti', 'Niemi', 2, 5),
('Pekka', 'Mutka', 89, 6),
('Vladimir', 'Putti', 122, 7),
('Björje', 'Burje', 61, 8),
('Viivi', 'Vatukka', 74, 9),
('Liisi', 'Riisipiisi', 0, 10);

-- uusi
INSERT INTO Toteutus(periodi, alkupvm, koepvm, info, vastuu_id, kurssi_id) 
VALUES (2, NOW() + '1 year'::INTERVAL * ROUND(RANDOM() * 1), NOW() + '1 year'::INTERVAL * (ROUND(RANDOM() * 1) + 1), 'Helppo kurssi', 1, 1),
(3, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Paha kurssi', 2, 2),
(4, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Sellanen', 1, 2),
(1, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'jAHAS', 2, 1),
(2, NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 'Rip', 2, 3);

-- uusi
--INSERT INTO Ilmoittautuminen(tote_id, ilmoittautuja) 
--VALUES (1, 4), (2, 4), (2, 5), (4, 5), (3, 4), (5, 5), (5, 4);

-- uusi
--INSERT INTO Suoritus(pvm, arvosana, tote_id, suorittaja) 
--VALUES (NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 4, 1, 4),
--(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 1, 2, 4),
--(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 3, 3, 4),
--(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 2, 1, 5),
--(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 3, 2, 5),
--(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 4, 4, 5),
--(NOW() - '1 year'::INTERVAL * ROUND(RANDOM() * 10), 5, 5, 5);

