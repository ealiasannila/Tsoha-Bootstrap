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
        $ryhmat = Kayttajaryhma::haeKaikki();
        View::make('ryhmahallinta.html', array('ryhmat' => $ryhmat));
    }

    public static function lisaaRyhma() {
        $nimi = $_POST['ryhma'];
        $ryhma = new Kayttajaryhma(array('kuvaus' => $nimi));
        //VALIDOINTI
        $ryhma->lisaa();
        Redirect::to('/kayttajaryhma/' . $ryhma->id);
    }

    public static function poistaRyhma() {

        $ryhmaid = $_POST['ryhma'];
        $ryhma = Kayttajaryhma::haeYksi($ryhmaid);
        $ryhma->poistaRyhma();
        Redirect::to('/ryhmahallinta');
    }

    public static function lisaaJasen($ryhmaid) {

        $jasen = $_POST['kayttaja'];

        $ryhma = Kayttajaryhma::haeYksi($ryhmaid);
        $ryhma->lisaaJasen($jasen);
        Redirect::to('/kayttajaryhma/' . $ryhmaid);
    }

    public static function poistaJasen($ryhmaid) {
        $jasen = $_POST['kayttaja'];


        $ryhma = Kayttajaryhma::haeYksi($ryhmaid);
        $ryhma->poistaJasen($jasen);
        Redirect::to('/kayttajaryhma/' . $ryhmaid);
    }

}
