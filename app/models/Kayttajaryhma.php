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
    }

    public static function haeKayttajalla($kayttajaId) {

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttajaryhma WHERE id IN (SELECT kayttaja FROM KayttajaKuuluu WHERE kayttaja = :kayttaja)');
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

        $kysely = DB::connection()->prepare('SELECT * FROM Kayttajaryhma WHERE id IN (SELECT aihealue FROM aihealueKuuluu WHERE aihealue = :aihealue)');
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

}
