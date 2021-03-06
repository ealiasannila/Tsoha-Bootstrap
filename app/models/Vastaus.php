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
class Vastaus extends BaseModel {

    public $id, $laatija, $otsikko, $teksti, $aihe, $julkaistu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
        $this->validators = array('validoi_teksti', 'validoi_otsikko');
    }

    public function laatijanNimi() {
        $kayttaja = Kayttaja::haeYksi($this->laatija);
        return $kayttaja->kayttajatunnus;
    }

    public static function haeHakusanalla($hakusanat) {

        $vastaukset = array();
        $kaikki = self::haeKaikki();
        for ($i = 0; $i < count($hakusanat); $i++) {
            if (empty($hakusanat[$i])) {
                return;
            }
            for ($j = 0; $j < count($kaikki); $j++) {
                if (strpos($kaikki[$j]->teksti, $hakusanat[$i]) !== false) {
                    $vastaukset[] = $kaikki[$j];
                }
            }
        }
        return $vastaukset;
    }

    public static function haeKaikki() {

        $kysely = DB::connection()->prepare('SELECT * FROM Vastaus');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $vastaukset = array();

        foreach ($rivit as $rivi) {
            $vastaukset[] = new Vastaus(array(
                'id' => $rivi['id'],
                'laatija' => $rivi['laatija'],
                'otsikko' => $rivi['otsikko'],
                'teksti' => $rivi['teksti'],
                'aihe' => $rivi['aihe'],
                'julkaistu' => $rivi['julkaistu'],
            ));
        }

        return $vastaukset;
    }

    public static function haeKayttajalla($kayttajaId) {

        $kysely = DB::connection()->prepare('SELECT * FROM Vastaus WHERE laatija = :laatija ORDER BY julkaistu');
        $kysely->execute(array('laatija' => $kayttajaId));
        $rivit = $kysely->fetchAll();
        $vastaukset = array();

        foreach ($rivit as $rivi) {
            $vastaukset[] = new Vastaus(array(
                'id' => $rivi['id'],
                'laatija' => $rivi['laatija'],
                'otsikko' => $rivi['otsikko'],
                'teksti' => $rivi['teksti'],
                'aihe' => $rivi['aihe'],
                'julkaistu' => $rivi['julkaistu'],
            ));
        }

        return $vastaukset;
    }

    public static function haeAiheella($aiheId) {

        $kysely = DB::connection()->prepare('SELECT * FROM Vastaus WHERE aihe = :aihe ORDER BY julkaistu');
        $kysely->execute(array('aihe' => $aiheId));
        $rivit = $kysely->fetchAll();
        $vastaukset = array();

        foreach ($rivit as $rivi) {
            $vastaukset[] = new Vastaus(array(
                'id' => $rivi['id'],
                'laatija' => $rivi['laatija'],
                'otsikko' => $rivi['otsikko'],
                'teksti' => $rivi['teksti'],
                'aihe' => $rivi['aihe'],
                'julkaistu' => $rivi['julkaistu'],
            ));
        }

        return $vastaukset;
    }

    public static function haeAihealueella($aihealueId) {

        $kysely = DB::connection()->prepare('SELECT * FROM Vastaus WHERE aihe IN (SELECT id FROM Aihe WHERE aihealue = :aihealue) ORDER BY julkaistu');
        $kysely->execute(array('aihealue' => $aihealueId));
        $rivit = $kysely->fetchAll();
        $vastaukset = array();

        foreach ($rivit as $rivi) {
            $vastaukset[] = new Vastaus(array(
                'id' => $rivi['id'],
                'laatija' => $rivi['laatija'],
                'otsikko' => $rivi['otsikko'],
                'teksti' => $rivi['teksti'],
                'aihe' => $rivi['aihe'],
                'julkaistu' => $rivi['julkaistu'],
            ));
        }

        return $vastaukset;
    }

    public static function haeYksi($id) {

        $kysely = DB::connection()->prepare('SELECT * FROM Vastaus WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));

        $rivi = $kysely->fetch();

        if (!$rivi) {
            return null;
        }

        $vastaus = new Vastaus(array(
            'id' => $rivi['id'],
            'laatija' => $rivi['laatija'],
            'otsikko' => $rivi['otsikko'],
            'teksti' => $rivi['teksti'],
            'aihe' => $rivi['aihe'],
            'julkaistu' => $rivi['julkaistu'],
        ));


        return $vastaus;
    }

    public function validoi_teksti() {
        $errors = array();
        if (!$this->validate_strlength($this->teksti, 1, 5000)) {
            $errors[] = 'Tekstin pituuden tulee olla välillä 1-5000';
        }
        return $errors;
    }

    public function validoi_otsikko() {
        $errors = array();
        if (!$this->validate_strlength($this->otsikko, 1, 50)) {
            $errors[] = 'Otsikon pituuden tulee olla välillä 1-50';
        }
        return $errors;
    }

    public function lisaa() {

        $kysely = DB::connection()->prepare('INSERT INTO Vastaus (otsikko, teksti, laatija, aihe) VALUES (:otsikko, :teksti, :laatija, :aihe) RETURNING id, julkaistu');
        $kysely->execute(array(
            'otsikko' => $this->otsikko,
            'teksti' => $this->teksti,
            'laatija' => $this->laatija,
            'aihe' => $this->aihe));

        $rivi = $kysely->fetch();

        $this->id = $rivi['id'];
        $this->julkaistu = $rivi['julkaistu'];
    }

    public function muokkaa() {
        $kysely = DB::connection()->prepare('UPDATE Vastaus set teksti = :teksti WHERE id = :id');
        $kysely->execute(array(
            'teksti' => $this->teksti,
            'id' => $this->id));
    }

    public function poista() {
        $aihe = Aihe::haeYksi($this->aihe);
        if ($aihe->vastauksienMaara() <= 1) {
            $aihe->poista();
        }

        $kysely = DB::connection()->prepare('DELETE FROM Vastaus WHERE id = :id');
        $kysely->execute(array(
            'id' => $this->id));
        
    }

}
