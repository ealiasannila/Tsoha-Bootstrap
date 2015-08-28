-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (kayttajatunnus, salasana) VALUES ('yrjoyllapito', 'kuningas');
INSERT INTO Kayttaja (kayttajatunnus, salasana) VALUES ('taunotrolli', 'peikko');
INSERT INTO Kayttaja (kayttajatunnus, salasana) VALUES ('raunoraggari', 'punk');
INSERT INTO Kayttaja (kayttajatunnus, salasana) VALUES ('askoaristokraatti', 'sivistys');

INSERT INTO KayttajaRyhma (kuvaus) VALUES ('Yllapito');
INSERT INTO KayttajaRyhma (kuvaus) VALUES ('Pahikset');

INSERT INTO Aihealue (otsikko, kuvaus) VALUES ('Kahvipoytakeskustelu', 'Mita sohvilla tapahtuu?');
INSERT INTO Aihealue (otsikko, kuvaus) VALUES ('Sonta osio', 'Mita sohvilla tapahtuu?');
INSERT INTO Aihealue (otsikko, kuvaus) VALUES ('Pahisten jutut', 'anarkiaa ja kaaosta');

INSERT INTO Aihe (aihealue) VALUES (1);
INSERT INTO Aihe (aihealue) VALUES (1);
INSERT INTO Aihe (aihealue) VALUES (2);
INSERT INTO Aihe (aihealue) VALUES (3);

INSERT INTO Vastaus (otsikko, teksti, aihe, laatija) VALUES ('Uusi moccamaster on oranssi?', 'Siis mita ihmetta?? oranssi?? selittakaa.', 1,1);
INSERT INTO Vastaus (otsikko, teksti, aihe, laatija) VALUES ('Uusi moccamaster on oranssi?', 'Hähää no niin on!', 1,2);
INSERT INTO Vastaus (otsikko, teksti, aihe, laatija) VALUES ('Uusi moccamaster on oranssi?', 'pöyristyttävää käytöstä.', 1,4);

INSERT INTO Vastaus (otsikko, teksti, aihe, laatija) VALUES ('Keksit ovat olleet hieman kuivia', 'Olen valitettavasti havainnnut tälläistä viimeaikoina. Olen pettynyt', 2,4);


INSERT INTO Vastaus (otsikko, teksti, aihe, laatija) VALUES ('Trollit trolaa', 'trollolloll', 3,3);

INSERT INTO Vastaus (otsikko, teksti, aihe, laatija) VALUES ('Maailmanvalloitus', 'evil plans for world domination', 4,3);
INSERT INTO Vastaus (otsikko, teksti, aihe, laatija) VALUES ('Maailmanvalloitus', 'ei tuu toimii...', 4,2);

INSERT INTO KayttajaKuuluu (kayttaja, KayttajaRyhma) VALUES (1,1);
INSERT INTO KayttajaKuuluu (kayttaja, KayttajaRyhma) VALUES (2,2);
INSERT INTO KayttajaKuuluu (kayttaja, KayttajaRyhma) VALUES (3,2);


INSERT INTO AihealueKuuluu (aihealue, KayttajaRyhma) VALUES (3,2);
