<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VastausController
 *
 * @author elias
 */
class UusiAiheController extends BaseController {

    public static function listaa($id) {

        $aihealue = Aihealue::haeYksi($id);

        View::make('uusiAihe.html', array('aihealue' => $aihealue));
    }

    public static function lisaaAihe($alueId) {
        $lomakkeenTiedot = $_POST;
        $aihe = new Aihe(array(
            'aihealue' => $alueId
        ));
        $aihe->lisaa();
        
        $aloitus = new Vastaus(array(
            'otsikko' => $lomakkeenTiedot['otsikko'],
            'teksti' => $lomakkeenTiedot['teksti'],
            'laatija' => 1,
            'aihe' => $aihe->id
        ));
        $aloitus->lisaa();

        Redirect::to('/aihe/' . $aihe->id);
    }

}
