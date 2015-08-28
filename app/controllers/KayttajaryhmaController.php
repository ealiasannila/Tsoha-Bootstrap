<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kayttajaController
 *
 * @author elias
 */
class KayttajaRyhmaController extends BaseController {
    /*
      public static function listaa($id) {

      $kayttaja = Kayttaja::haeYksi($id);
      View::make('kayttaja.html', array('kayttaja' => $kayttaja));
      } */

    public static function nayta($id) {

        $ryhma = Kayttajaryhma::haeYksi($id);
        $kayttajat = Kayttaja::haeKaikki();
        View::make('kayttajaryhma.html', array('ryhma' => $ryhma, 'kayttajat' => $kayttajat));
    }

    public static function listaa() {
        self::check_yllapito();

        $ryhmat = Kayttajaryhma::haeKaikki();
        View::make('ryhmahallinta.html', array('ryhmat' => $ryhmat));
    }

    public static function lisaaRyhma() {
        self::check_yllapito();

        $nimi = $_POST['ryhma'];
        $ryhma = new Kayttajaryhma(array('kuvaus' => $nimi));
        $errors = $ryhma->errors();
        if (count($errors) == 0) {

            $ryhma->lisaa();
            Redirect::to('/kayttajaryhma/' . $ryhma->id);
        }
        View::make('ryhmahallinta.html', array('virheet' => $errors, 'ryhmat' => Kayttajaryhma::haeKaikki()));
    }

    public static function poistaRyhma() {
        self::check_yllapito();

        $ryhmaid = $_POST['ryhma'];
        $ryhma = Kayttajaryhma::haeYksi($ryhmaid);
        $ryhma->poistaRyhma();
        Redirect::to('/ryhmahallinta');
    }

    public static function lisaaJasen($ryhmaid) {
        self::check_yllapito();

        $jasen = $_POST['kayttaja'];

        $ryhma = Kayttajaryhma::haeYksi($ryhmaid);
        if (!Kayttaja::haeYksi($jasen)->kuuluuRyhmaan($ryhmaid)) {
            $ryhma->lisaaJasen($jasen);
            Redirect::to('/kayttajaryhma/' . $ryhmaid);
        }
        View::make('kayttajaryhma.html', array('ryhma' => $ryhma, 'kayttajat' => Kayttaja::haeKaikki(), 'virheet' => array('käyttäjä kuuluu jo ryhmään')));
    }

    public static function poistaJasen($ryhmaid) {
        self::check_yllapito();

        $jasen = $_POST['kayttaja'];


        $ryhma = Kayttajaryhma::haeYksi($ryhmaid);
        $ryhma->poistaJasen($jasen);
        Redirect::to('/kayttajaryhma/' . $ryhmaid);
    }

}
