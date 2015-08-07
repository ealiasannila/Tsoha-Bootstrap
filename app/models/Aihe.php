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
class Aihe extends BaseModel {

    public $id, $aihealue;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public function aihealueenOtsikko() {
        $aihealue = Aihealue::haeYksi($this->aihealue);
        return $aihealue->otsikko;
    }

    public function viimeisinViesti() {
        $vastaukset = $this->vastaukset();
        return $vastaukset[count($vastaukset) - 1];
    }

    public function vastaukset() {
        return Vastaus::haeAiheella($this->id);
    }

    public function vastauksienMaara() {
        return count($this->vastaukset());
    }

    public static function haeAihealueella($aihealueId) {

        $kysely = DB::connection()->prepare('SELECT * FROM Aihe WHERE aihealue = :aihealue');
        $kysely->execute(array('aihealue' => $aihealueId));
        $rivit = $kysely->fetchAll();
        $aiheet = array();

        foreach ($rivit as $rivi) {
            $aiheet[] = new Aihe(array(
                'id' => $rivi['id'],
                'aihealue' => $rivi['aihealue']
            ));
        }

        return $aiheet;
    }

    public static function haeKaikki() {

        $kysely = DB::connection()->prepare('SELECT * FROM Aihe');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $aiheet = array();

        foreach ($rivit as $rivi) {
            $aiheet[] = new Aihe(array(
                'id' => $rivi['id'],
                'aihealue' => $rivi['aihealue']
            ));
        }

        return $aiheet;
    }

    public static function haeYksi($id) {

        $kysely = DB::connection()->prepare('SELECT * FROM Aihe WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));

        $rivi = $kysely->fetch();

        if (!$rivi) {
            return null;
        }

        $aihe = new Aihe(array(
            'id' => $rivi['id'],
            'aihealue' => $rivi['aihealue'],
        ));


        return $aihe;
    }

    public function lisaa() {

        $kysely = DB::connection()->prepare('INSERT INTO Aihe (aihealue) VALUES (:aihealue) RETURNING id');
        $kysely->execute(array(
            'aihealue' => $this->aihealue));

        $rivi = $kysely->fetch();

        $this->id = $rivi['id'];
    }

}
