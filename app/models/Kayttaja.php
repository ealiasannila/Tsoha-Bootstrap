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
    }

    public function viestit() {
        return Vastaus::haeKayttajalla($this->id);
    }

    public function kayttajaryhmat() {
        return Kayttajaryhma::haeKayttajalla($this->id);
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

        $kysely = DB::connection()->prepare('INSERT INTO Kayttaja (kayttajatunnus, salasana) VALUES (:kayttajatunnus, :salasana) RETURNING id liittynyt');
        $kysely->execute(array(
            'salasana' => $this->salasana,
            'kayttajatunnus' => $this->kayttajatunnus));

        $rivi = $kysely->fetch();

        $this->id = $rivi['id'];
        $this->liittynyt = $rivi['liittynyt'];
    }

    public static function tunnista($kayttajatunnus, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1', array('kayttajatunnus' => $kayttajatunnus, 'password' => $salasana));
        $query->execute(array(
            'salasana' => $salasana,
            'kayttajatunnus' => $kayttajatunnus));
        $rivi = $query->fetch();
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
