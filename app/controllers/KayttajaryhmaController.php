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
    }*/
    
    public static function nayta($id) {

        $ryhma = Kayttajaryhma::haeYksi($id);
        View::make('kayttajaryhma.html', array('ryhma' => $ryhma));
    }
}
