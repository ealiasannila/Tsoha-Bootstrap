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
class FoorumiController {

    public static function listaa() {

        $aihealueet = Aihealue::haeKaikki(); //muutetaan hae käyttäjäryhmillä
        View::make('foorumi.html', array('aihealueet' => $aihealueet));
    }

}
