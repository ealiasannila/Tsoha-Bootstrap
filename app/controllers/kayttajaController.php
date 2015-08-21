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
class kayttajaController extends BaseController {

    public static function listaa($id) {

        $kayttaja = Kayttaja::haeYksi($id);
        View::make('kayttaja.html', array('kayttaja' => $kayttaja));
    }

    public static function naytaKirjautuminen() {
        View::make('kirjaudu.html');
    }

    public static function naytaRekisteroityminen() {
        View::make('rekisteroidy.html');
    }

    public static function rekisteroidy() {
        $lomakkeenTiedot = $_POST;

        $kayttaja = new Kayttaja(array(
            'kayttajatunnus' => $lomakkeenTiedot['kayttajatunnus'],
            'salasana' => $lomakkeenTiedot['salasana']
        ));

        $errors = $kayttaja->errors();
        if (count($errors) == 0) {

            if ($lomakkeenTiedot['salasanauudestaan'] != $kayttaja->salasana) {
                $errors[] = "salasanat eivät täsmää";
            } else {

                $kayttaja->lisaa();
                Redirect::to('/');
            }
        }
            
        View::make('rekisteroidy.html', array('kayttaja' => $kayttaja, 'virheet' => $errors));
        
    }

    public static function teeKirjautuminen() {
        $params = $_POST;

        $kayttaja = Kayttaja::tunnista($params['kayttajatunnus'], $params['salasana']);

        if (!$kayttaja) {
            View::make('/kirjaudu.html', array('virheet' => 'Väärä käyttäjätunnus tai salasana!', 'kayttajatunnus' => $params['kayttajatunnus']));
        } else {
            $_SESSION['user'] = $kayttaja->id;

            Redirect::to('/');
        }
    }

    public static function kirjauduUlos() {
        $_SESSION['user'] = null;
        Redirect::to('/');
    }

}
