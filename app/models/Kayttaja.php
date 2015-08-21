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
class Kayttaja extends BaseModel {

    public $id, $kayttajatunnus, $salasana, $liittynyt;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
        $this->validators = array('validoi_kayttajatunnus');
    }

    public function viestit() {
        return Vastaus::haeKayttajalla($this->id);
    }

    public function kayttajaryhmat() {
        return Kayttajaryhma::haeKayttajalla($this->id);
    }

    public function kuuluuRyhmaan($ryhmaid) {
        if (in_array(Kayttajaryhma::haeYksi($ryhmaid), $this->kayttajaryhmat())) {
            return true;
        }
        return false;
    }

    public function vastauksienMaara() {
        return count($this->viestit());
    }

    public static function haeKaikki() {

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $kayttajat = array();

        foreach ($rivit as $rivi) {
            $kayttajat[] = new Kayttaja(array(
                'id' => $rivi['id'],
                'kayttajatunnus' => $rivi['kayttajatunnus'],
                'salasana' => $rivi['salasana'],
                'liittynyt' => $rivi['liittynyt']
            ));
        }

        return $kayttajat;
    }

    public static function haeYksi($id) {

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));

        $rivi = $kysely->fetch();

        if (!$rivi) {
            return null;
        }

        $kayttaja = new Kayttaja(array(
            'id' => $rivi['id'],
            'kayttajatunnus' => $rivi['kayttajatunnus'],
            'salasana' => $rivi['salasana'],
            'liittynyt' => $rivi['liittynyt']
        ));


        return $kayttaja;
    }

    public function lisaa() {


        $kysely = DB::connection()->prepare('INSERT INTO Kayttaja (kayttajatunnus, salasana) VALUES (:kayttajatunnus, :salasana) RETURNING id');
        $kysely->execute(array(
            'salasana' => $this->salasana,
            'kayttajatunnus' => $this->kayttajatunnus));

        $rivi = $kysely->fetch();

        $this->id = $rivi['id'];
    }

    public function validoi_kayttajatunnus() {
        $errors = array();

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus LIMIT 1');
        $kysely->execute(array(
            'kayttajatunnus' => $this->kayttajatunnus));
        $rivi = $kysely->fetch();
        if ($rivi) {
            $errors[] = 'kayttajatunnus jo käytössä';
        } else {
            if (!$this->validate_strlength($this->kayttajatunnus, 1, 50)) {
                $errors[] = 'käyttäjätunnuksen pituuden tulee olla välilä 1-50';
            }
        }
        return $errors;
    }

    public function validoi_salasana() {
        $errors = array();
        if (!$this->validate_strlength($this->salasana, 4, 50)) {
            $errors[] = 'salasanan pituuden tulee olla välilä 4-50';
        }
        return $errors;
    }

    public static function tunnista($kayttajatunnus, $salasana) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1');
        $kysely->execute(array(
            'salasana' => $salasana,
            'kayttajatunnus' => $kayttajatunnus));
        $rivi = $kysely->fetch();
        if ($rivi) {
            return new Kayttaja(array(
                'id' => $rivi['id'],
                'kayttajatunnus' => $rivi['kayttajatunnus'],
                'salasana' => $rivi['salasana'],
                'liittynyt' => $rivi['liittynyt']
            ));
        } else {
            return NULL;
        }
    }

}
