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
class VastausController extends BaseController {

    public static function hae() {
        $hakusanat = $_POST['hakusanat'];
        
        $hakusanat = explode(" ",$hakusanat);
        $vastaukset = Vastaus::haeHakusanalla($hakusanat);

        View::make('hakutulokset.html', array('vastaukset' => $vastaukset));
    }

    private static function tarkistaKayttaja($viestiId) {
        if (self::get_user_logged_in()->id != Vastaus::haeYksi($viestiId)->laatija) {

            Redirect::to('/aihe/' . Vastaus::haeYksi($viestiId)->aihe);
        }
    }

    public static function naytaMuokkaus($id) {

        self::tarkistaKayttaja($id);
        $vastaus = Vastaus::haeYksi($id);
        $aihe = Aihe::haeYksi($vastaus->aihe);
        View::make('muokkaaVastaus.html', array('vastaus' => $vastaus, 'aihe' => $aihe));
    }

    public static function muokkaaVatausta($id) {

        self::tarkistaKayttaja($id);
        $lomakkeenTiedot = $_POST;
        $vastaus = Vastaus::haeYksi($id);
        $vastaus->teksti = $lomakkeenTiedot['teksti'];


        $errors = $vastaus->errors();
        if (count($errors) == 0) {

            $vastaus->muokkaa();
            Redirect::to('/aihe/' . $vastaus->aihe);
        } else {
            $aihe = Aihe::haeYksi($vastaus->aihe);
            View::make('muokkaaVastaus.html', array('aihe' => $aihe, 'vastaus' => $vastaus, 'virheet' => $errors));
        }
    }

    public static function poista($id) {

        self::tarkistaKayttaja($id);
        $vastaus = Vastaus::haeYksi($id);
        $vastaus->poista();

        if (Aihe::haeYksi($vastaus->aihe)) {
            Redirect::to('/aihe/' . $vastaus->aihe);
        } else {
            Redirect::to('/');
        }
    }

    public static function naytaLisays($id) {

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
            'laatija' => BaseController::get_user_logged_in()->id,
            'aihe' => $aiheId
        ));

        $errors = $vastaus->errors();
        if (count($errors) == 0) {

            $vastaus->lisaa();
            Redirect::to('/aihe/' . $vastaus->aihe);
        } else {
            View::make('uusiVastaus.html', array('aihe' => $aihe, 'teksti' => $vastaus->teksti, 'virheet' => $errors));
        }
    }

}
