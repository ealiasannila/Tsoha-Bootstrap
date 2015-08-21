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

    public static function listaa($id) {

        $aihealue = Aihealue::haeYksi($id);
        View::make('aihealue.html', array('aihealue' => $aihealue));
    }

    public static function naytaLisays() {
        self::check_yllapito();
        View::make('uusiAihealue.html');
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
            Redirect::to('/aihealue/' . $aihealue->id);
        }
        View::make('uusiAihealue.html', array('aihealue' => $aihealue, 'virheet' => $virheet));
    }

    public static function naytaMuokkaus($id) {
        self::check_yllapito();

        $aihealue = Aihealue::haeYksi($id);
        View::make('muokkaaAihealue.html', array('aihealue' => $aihealue));
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
            Redirect::to('/aihealue/' . $aihealue->id);
        } else {
            View::make('muokkaaAihealue.html', array('aihealue' => $aihealue, 'virheet' => $errors));
        }
    }

    public static function poista($id) {
        self::check_yllapito();

        $aihealue = Aihealue::haeYksi($id);
        $aihealue->poista();

        Redirect::to('/');
    }

}
