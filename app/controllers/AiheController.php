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
class AiheController extends BaseController {

    public static function listaa($id) {

        $aihe = Aihe::haeYksi($id);

        View::make('aihe.html', array('aihe' => $aihe));
    }

    public static function naytaLisays($id) {

        $aihealue = Aihealue::haeYksi($id);

        View::make('uusiAihe.html', array('aihealue' => $aihealue));
    }

    public static function lisaaAihe($alueId) {
        $lomakkeenTiedot = $_POST;
        $aihe = new Aihe(array(
            'aihealue' => $alueId
        ));
        $virheetAihe = $aihe->errors();
        if (count($virheetAihe) == 0) {

            $aloitus = new Vastaus(array(
                'otsikko' => $lomakkeenTiedot['otsikko'],
                'teksti' => $lomakkeenTiedot['teksti'],
                'laatija' => BaseController::get_user_logged_in()->id,
                'aihe' => -1
            ));

            $virheetAloitus = $aloitus->errors();
            if (count($virheetAloitus) == 0) {
                $aihe->lisaa();
                $aloitus->aihe = $aihe->id;

                $aloitus->lisaa();

                Redirect::to('/aihe/' . $aihe->id);
            }
        }
        $aihealue = Aihealue::haeYksi($alueId);
        View::make('uusiAihe.html', array('aihealue' => $aihealue, 'virheet' => $virheetAloitus, 'aloitus' => $aloitus));
    }

}
