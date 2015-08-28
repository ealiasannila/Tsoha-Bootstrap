<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AiheController
 *
 * @author elias
 */
class AihealueController extends BaseController {

    public static function listaa() {
        $aihealueet = Aihealue::haeKaikki();
        View::make('foorumi.html', array('aihealueet' => $aihealueet));
    }

    public static function nayta($id) {
        $aihealue = Aihealue::haeYksi($id);
        $kayttaja = self::get_user_logged_in();
        if ($aihealue->kayttajaSaaNahda($kayttaja)) {
            View::make('aihealue.html', array('aihealue' => $aihealue));
        }
        Redirect::to('/');
    }

    public static function naytaLisays() {
        self::check_yllapito();
        $kayttajaryhmat = Kayttajaryhma::haeKaikki();
        View::make('uusiAihealue.html', array('kayttajaryhmat' => $kayttajaryhmat));
    }

    public static function lisaaAihealue() {
        self::check_yllapito();

        $lomakkeenTiedot = $_POST;
        $aihealue = new Aihealue(array(
            'otsikko' => $lomakkeenTiedot['otsikko'],
            'kuvaus' => $lomakkeenTiedot['kuvaus']
        ));



        $virheet = $aihealue->errors();
        if (count($virheet) == 0) {
            $aihealue->lisaa();

            if (array_key_exists('ryhmat', $lomakkeenTiedot)) {
                $ryhmat = $lomakkeenTiedot['ryhmat'];

                for ($i = 0; $i < count($ryhmat); $i++) {
                    $aihealue->lisaaAlueelleRyhma($ryhmat[$i]);
                }
            }
            Redirect::to('/aihealue/' . $aihealue->id);
        }
        $kayttajaryhmat = Kayttajaryhma::haeKaikki();
        View::make('uusiAihealue.html', array('aihealue' => $aihealue, 'virheet' => $virheet, 'kayttajaryhmat' => $kayttajaryhmat));
    }

    public static function naytaMuokkaus($id) {
        self::check_yllapito();

        $aihealue = Aihealue::haeYksi($id);
        $kayttajaryhmat = Kayttajaryhma::haeKaikki();

        View::make('muokkaaAihealue.html', array('aihealue' => $aihealue, 'kayttajaryhmat' => $kayttajaryhmat));
    }

    public static function muokkaa($id) {
        self::check_yllapito();

        $lomakkeenTiedot = $_POST;
        $aihealue = Aihealue::haeYksi($id);
        $aihealue->otsikko = $lomakkeenTiedot['otsikko'];
        $aihealue->kuvaus = $lomakkeenTiedot['kuvaus'];


        $errors = $aihealue->errors();
        
        if (count($errors) == 0) {
            $aihealue->muokkaa();
            $aihealue->poistaAlueenRyhmat();
            if (array_key_exists('ryhmat', $lomakkeenTiedot)) {
                $ryhmat = $lomakkeenTiedot['ryhmat'];

                for ($i = 0; $i < count($ryhmat); $i++) {
                    $aihealue->lisaaAlueelleRyhma($ryhmat[$i]);
                }
            }
            Redirect::to('/aihealue/' . $aihealue->id);
        } else {
            $kayttajaryhmat = Kayttajaryhma::haeKaikki();
            View::make('muokkaaAihealue.html', array('aihealue' => $aihealue, 'virheet' => $errors, 'kayttajaryhmat' => $kayttajaryhmat));
        }
    }

    public static function poista($id) {
        self::check_yllapito();

        $aihealue = Aihealue::haeYksi($id);
        $aihealue->poista();

        Redirect::to('/');
    }

}
