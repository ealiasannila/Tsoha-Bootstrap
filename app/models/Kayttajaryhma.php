<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vastaus
 *
 * @author elias
 */
class Kayttajaryhma extends BaseModel {

    public $id, $kuvaus;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
        $this->validators = array('validoi_ryhma');
    }

    public function lisaaRyhma() {

        $kysely = DB::connection()->prepare('INSERT INTO Kayttajaryhma (kuvauss) VALUES (:kuvaus) RETURNING id');
        $kysely->execute(array(
            'kuvaus' => $this->kuvaus));
        $rivi = $kysely->fetch();

        $this->id = $rivi['id'];
    }

    public function poistaRyhma() {

        $kysely = DB::connection()->prepare('DELETE FROM Kayttajaryhma WHERE id = :id');
        $kysely->execute(array(
            'id' => $this->id));
    }

    public function poistaJasen($kayttajaid) {

        $kysely = DB::connection()->prepare('DELETE FROM KayttajaKuuluu WHERE kayttaja = :kayttaja AND kayttajaryhma=:ryhma');
        $kysely->execute(array(
            'kayttaja' => $kayttajaid,
            'ryhma' => $this->id));
    }

    public function lisaaJasen($kayttjaid) {

        $kysely = DB::connection()->prepare('INSERT INTO KayttajaKuuluu (kayttaja, kayttajaryhma) VALUES (:kayttaja, :ryhma)');
        $kysely->execute(array(
            'kayttaja' => $kayttjaid,
            'ryhma' => $this->id));
    }

    public function haeJasenet() {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id IN (SELECT kayttaja FROM KayttajaKuuluu WHERE kayttajaryhma = :kayttajaryhma)');
        $kysely->execute(array('kayttajaryhma' => $this->id));

        $rivit = $kysely->fetchAll();
        $jasenet = array();

        foreach ($rivit as $rivi) {
            $jasenet[] = new Kayttaja(array(
                'id' => $rivi['id'],
                'kayttajatunnus' => $rivi['kayttajatunnus'],
                'salasana' => $rivi['salasana'],
                'liittynyt' => $rivi['liittynyt']
            ));
        }

        return $jasenet;
    }

    public static function haeKayttajalla($kayttajaId) {

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttajaryhma WHERE id IN (SELECT kayttajaryhma FROM KayttajaKuuluu WHERE kayttaja = :kayttaja)');
        $kysely->execute(array('kayttaja' => $kayttajaId));

        $rivit = $kysely->fetchAll();
        $kayttajaryhmat = array();

        foreach ($rivit as $rivi) {
            $kayttajaryhmat[] = new Kayttajaryhma(array(
                'id' => $rivi['id'],
                'kuvaus' => $rivi['kuvaus']
            ));
        }

        return $kayttajaryhmat;
    }

    public static function haeAihealueella($aihealueId) {

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttajaryhma WHERE id IN (SELECT kayttajaryhma FROM aihealueKuuluu WHERE aihealue = :aihealue)');
        $kysely->execute(array('aihealue' => $aihealueId));

        $rivit = $kysely->fetchAll();
        $kayttajaryhmat = array();

        foreach ($rivit as $rivi) {
            $kayttajaryhmat[] = new Kayttajaryhma(array(
                'id' => $rivi['id'],
                'kuvaus' => $rivi['kuvaus']
            ));
        }

        return $kayttajaryhmat;
    }

    public static function haeKaikki() {

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttajaryhma');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $kayttajaryhmat = array();

        foreach ($rivit as $rivi) {
            $kayttajaryhmat[] = new Kayttajaryhma(array(
                'id' => $rivi['id'],
                'kuvaus' => $rivi['kuvaus']
            ));
        }

        return $kayttajaryhmat;
    }

    public static function haeYksi($id) {

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttajaryhma WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));

        $rivi = $kysely->fetch();

        if (!$rivi) {
            return null;
        }

        $kayttajaryhma = new Kayttajaryhma(array(
            'id' => $rivi['id'],
            'kuvaus' => $rivi['kuvaus']
        ));


        return $kayttajaryhma;
    }

    public function lisaa() {

        $kysely = DB::connection()->prepare('INSERT INTO Kayttajaryhma (kuvaus) VALUES (:kuvaus) RETURNING id');
        $kysely->execute(array(
            'kuvaus' => $this->kuvaus));

        $rivi = $kysely->fetch();

        $this->id = $rivi['id'];
    }

    public function validoi_ryhma() {
        $errors = array();

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttajaryhma WHERE kuvaus = :kuvaus LIMIT 1');
        $kysely->execute(array(
            'kuvaus' => $this->kuvaus));
        $rivi = $kysely->fetch();
        if ($rivi) {
            $errors[] = 'käyttäjäryhmä on jo käytössä';
        } else {
            if (!$this->validate_strlength($this->kuvaus, 1, 50)) {
                $errors[] = 'Ryhmän nimen tulee olla välilä 1-50';
            }
        }
        return $errors;
    }

    public function validoi_uusiJasen($id) {
        $errors = array();
        $jasen = Kayttaja::haeYksi($id);
        echo 'ei vielä';
        if ($jasen->kuuluuRyhmaan($this->id)) {
            echo 'eroro';
            $errors[] = 'käyttäjä kuuluu jo ryhmään';
        }
        return $errors;
    }

}
