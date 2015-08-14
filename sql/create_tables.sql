-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE KayttajaRyhma(
    id SERIAL PRIMARY KEY,
    kuvaus varchar(100) NOT NULL
);

CREATE TABLE Aihealue(
    id SERIAL PRIMARY KEY,
    otsikko varchar(100) NOT NULL,
    kuvaus varchar(100) NOT NULL
);


CREATE TABLE Aihe(
    id SERIAL PRIMARY KEY,
    aihealue INTEGER REFERENCES Aihealue(id) ON DELETE cascade ON UPDATE cascade NOT NULL
);


CREATE TABLE Kayttaja(
    id SERIAL PRIMARY KEY,
    kayttajatunnus varchar(50) NOT NULL,
    salasana varchar(50) NOT NULL,
    liittynyt TIMESTAMP DEFAULT NOW() NOT NULL
);


CREATE TABLE Vastaus(
    id SERIAL PRIMARY KEY,
    otsikko varchar(100) NOT NULL,
    teksti varchar(5000) NOT NULL,
    julkaistu TIMESTAMP DEFAULT NOW() NOT NULL,
    laatija INTEGER REFERENCES Kayttaja(id) ON UPDATE cascade NOT NULL,
    aihe INTEGER REFERENCES Aihe(id) ON DELETE cascade ON UPDATE cascade NOT NULL
);

CREATE TABLE Luettu(
    kayttaja INTEGER REFERENCES Kayttaja(id) ON DELETE cascade ON UPDATE cascade NOT NULL,
    vastaus INTEGER REFERENCES Vastaus(id) ON DELETE cascade ON UPDATE cascade NOT NULL
);


CREATE TABLE KayttajaKuuluu(
    kayttaja INTEGER REFERENCES Kayttaja(id) ON DELETE cascade ON UPDATE cascade NOT NULL,
    kayttajaRyhma INTEGER REFERENCES KayttajaRyhma(id) ON DELETE cascade ON UPDATE cascade NOT NULL
);


CREATE TABLE AihealueKuuluu(
    aihealue INTEGER REFERENCES Aihealue(id) ON DELETE cascade ON UPDATE cascade NOT NULL,
    kayttajaRyhma INTEGER REFERENCES KayttajaRyhma(id) ON DELETE cascade ON UPDATE cascade NOT NULL
);

