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
class Aihealue extends BaseModel {

    public $id, $otsikko, $kuvaus;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
        $this->validators = array('validoi_kuvaus', 'validoi_otsikko');
    }

    public function viestit() {
        return Vastaus::haeAihealueella($this->id);
    }

    public function viestienMaara() {
        return count($this->viestit());
    }

    public function viimeisinViesti() {
        $viestit = $this->viestit();
        if (count($viestit) > 0) {
            return $viestit[count($viestit) - 1];
        }
    }

    public function aiheidenMaara() {
        return count($this->aiheet());
    }

    public function aiheet() {
        return Aihe::haeAihealueella($this->id);
    }

    public function kayttajaryhmat() {
        return Kayttajaryhma::haeAihealueella($this->id);
    }

    public function kayttajaSaaNahda($kayttaja) {
        $alueenryhmat = $this->kayttajaryhmat();
        if (count($alueenryhmat) == 0) {
            return true;
        }
        if ($kayttaja == null) {
            return false;
        }
        $kayttajanryhmat = Kayttajaryhma::haeKayttajalla($kayttaja->id);


        for ($j = 0; $j < count($kayttajanryhmat); $j++) {
            if($kayttajanryhmat[$j]->id==1){//ylläpto
                return true;
            }
            for ($i = 0; $i < count($alueenryhmat); $i++) {
                if ($alueenryhmat[$i]->id == $kayttajanryhmat[$j]->id) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function haeKaikki() {

        $kysely = DB::connection()->prepare('SELECT * FROM Aihealue');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $aihealueet = array();

        foreach ($rivit as $rivi) {
            $aihealueet[] = new Aihealue(array(
                'id' => $rivi['id'],
                'kuvaus' => $rivi['kuvaus'],
                'otsikko' => $rivi['otsikko']
            ));
        }

        return $aihealueet;
    }

    public static function haeYksi($id) {

        $kysely = DB::connection()->prepare('SELECT * FROM Aihealue WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));

        $rivi = $kysely->fetch();

        if (!$rivi) {
            return null;
        }

        $aihealue = new Aihealue(array(
            'id' => $rivi['id'],
            'kuvaus' => $rivi['kuvaus'],
            'otsikko' => $rivi['otsikko']
        ));


        return $aihealue;
    }

    public function validoi_otsikko() {
        $errors = array();
        if (!$this->validate_strlength($this->otsikko, 1, 50)) {
            $errors[] = 'Otsikon pituuden tulee olla välillä 1-5000';
        }
        return $errors;
    }

    public function validoi_kuvaus() {
        $errors = array();
        if (!$this->validate_strlength($this->kuvaus, 1, 50)) {
            $errors[] = 'kuvauksen pituuden tulee olla välillä 1-5000';
        }
        return $errors;
    }

    public function lisaa() {

        $kysely = DB::connection()->prepare('INSERT INTO Aihealue (kuvaus, otsikko) VALUES (:kuvaus, :otsikko) RETURNING id');
        $kysely->execute(array(
            'otsikko' => $this->otsikko,
            'kuvaus' => $this->kuvaus));

        $rivi = $kysely->fetch();

        $this->id = $rivi['id'];
    }

    public function lisaaAlueelleRyhma($ryhmaid) {
        $kysely = DB::connection()->prepare('INSERT INTO AihealueKuuluu (aihealue, KayttajaRyhma) VALUES (:aihealue, :ryhma)');
        $kysely->execute(array(
            'aihealue' => $this->id,
            'ryhma' => $ryhmaid
        ));
    }

    public function muokkaa() {
        $kysely = DB::connection()->prepare('UPDATE Aihealue set kuvaus = :kuvaus, otsikko = :otsikko WHERE id = :id');
        $kysely->execute(array(
            'kuvaus' => $this->kuvaus,
            'otsikko' => $this->otsikko,
            'id' => $this->id));
    }

    public function poista() {

        $kysely = DB::connection()->prepare('DELETE FROM Aihealue WHERE id = :id');
        $kysely->execute(array(
            'id' => $this->id));
    }

}
