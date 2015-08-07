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

    }
    
    public function viestit(){
        return Vastaus::haeAihealueella($this->id);
    }
    
    public function viestienMaara(){
        return count($this->viestit());
    }
    
    public function viimeisinViesti(){
        $viestit =  $this->viestit();
        return $viestit[count($viestit)-1];
    }

    public function aiheidenMaara(){
        return count($this->aiheet());
    }
    
    public function aiheet(){
        return Aihe::haeAihealueella($this->id);
    }
    
    public function kayttajaryhmat(){
        return Kayttajaryhma::haeAihealueella($this->id);
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

    public function lisaa() {

        $kysely = DB::connection()->prepare('INSERT INTO Aihealue (kuvaus, otsikko) VALUES (:kuvaus, :otsikko) RETURNING id');
        $kysely->execute(array(
        'otsikko' => $this->otsikko,
        'kuvaus' => $this->kuvaus));

        $rivi = $kysely->fetch();

        $this->id = $rivi['id'];
    }

}
