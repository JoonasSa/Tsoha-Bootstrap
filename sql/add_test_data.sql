INSERT INTO Kayttaja(username, password, admin, teacher)
VALUES ('Testi Jäbä', 'salasana', true, true), ('Lotta Suominen', 'salakala', false, true), ('Hermanni Pallovasara', 'spurdo', false, true),
('Banjo', 'Kemppainen', false, true), ('Matti Niemi', 'hunter2', false, false), ('Pekka Mutka', 'spooky123', false, false),
('Björje Burje', 'Burjo', false, false), ('Liisi Riisipiisi', 'Riisipiisi', false, false);


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
VALUES ('Matti', 'Niemi', 9, 5),
('Pekka', 'Mutka', 4, 6),
('Björje', 'Burje', 10, 7),
('Liisi', 'Riisipiisi', 5, 8);

INSERT INTO Toteutus(periodi, alkupvm, koepvm, info, vastuu_id, kurssi_id) 
VALUES (2, '2017-03-03', '2017-05-15', 'Ostakaa kurssi kirja hyvissä ajoin.', 1, 1),
(3, '2017-01-15', '2017-03-16', 'Boolean = 50/50.', 2, 2),
(4, '2017-03-05', '2017-05-15', 'Logiikka 1 jatkokurssi.', 1, 3),
(1, '2017-09-04', '2017-10-22', 'Titokone, voi pojat!', 3, 4),
(2, '2017-11-15', '2017-12-21', 'Kuljetuskerroksen kautta.', 2, 5),
(2, '2017-11-14', '2017-12-19', 'Rip', 3, 6),
(2, '2017-11-12', '2018-03-11', 'Syventävä kurssi. Esitietovaatimus: 100 op matikkaa.', 1, 7),
(2, '2017-11-13', '2017-12-22', '( ͡° ʖ ͡°)', 4, 8);

INSERT INTO Ilmoittautuminen(tote_id, ilmoittautuja) 
VALUES (1, 5), (1, 7), (2, 5), (2, 6), (2, 8), (3, 5), (4, 5), 
(4, 7), (4, 8), (5, 6), (5, 7), (5, 8), (6, 7), (6, 6), (7, 7), (7, 8),
(7, 6), (8, 5);

INSERT INTO Suoritus(pvm, arvosana, tote_id, suorittaja) 
VALUES ('2017-05-15', 4, 1, 5), ('2017-03-16', 3, 2, 5),
('2017-03-16', 4, 2, 6), ('2017-05-15', 2, 5, 7), ('2017-05-15', 5, 7, 7),
('2017-05-15', 3, 4, 8);