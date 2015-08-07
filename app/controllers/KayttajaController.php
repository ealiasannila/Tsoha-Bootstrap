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
class KayttajaController {

    public static function listaa() {

        $kayttaja = Kayttaja::haeYksi(1);
        View::make('kayttaja.html', array('kayttaja' => $kayttaja));
    }

}
