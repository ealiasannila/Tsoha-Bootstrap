-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (kayttajatunnus, salasana) VALUES ('KalleKayttaja', 'passu');
INSERT INTO KayttajaRyhma (kuvaus) VALUES ('Yllapito');
INSERT INTO Aihealue (otsikko, kuvaus) VALUES ('Kahvipoytakeskustelu', 'Mita sohvilla tapahtuu?');
INSERT INTO Aihe (aihealue) VALUES (1);
INSERT INTO Vastaus (otsikko, teksti, aihe, laatija) VALUES ('Uusi moccamaster on oranssi?', 'Siis mita ihmetta?? oranssi?? selittakaa.', 1,1);
INSERT INTO Luettu (kayttaja, vastaus) VALUES (1,1);
INSERT INTO KayttajaKuuluu (kayttaja, KayttajaRyhma) VALUES (1,1);
INSERT INTO AihealueKuuluu (aihealue, KayttajaRyhma) VALUES (1,1);
