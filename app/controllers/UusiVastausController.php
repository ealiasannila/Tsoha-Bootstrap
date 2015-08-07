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
class UusiVastausController extends BaseController {
    
    
    public static function listaa($id) {

        $aihe = Aihe::haeYksi($id);
        
        View::make('uusiVastaus.html', array('aihe' => $aihe));
    }
    
    
    public static function lisaaVastaus($aiheId) {
        $lomakkeenTiedot = $_POST;
        $aihe = Aihe::haeYksi($aiheId);
        $viestit = $aihe->vastaukset();
        $aloitus = $viestit[0];
        $vastaus = new Vastaus(array(
            'otsikko' => $aloitus->otsikko,
            'teksti' => $lomakkeenTiedot['teksti'],
            'laatija' => 1,
            'aihe' => $aiheId
        ));
        $vastaus->lisaa();
        

        Redirect::to('/aihe/' . $vastaus->aihe);
    }


    
}
