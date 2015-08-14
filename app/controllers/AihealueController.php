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
class AihealueController extends BaseController{

    

    public static function listaa($id) {

        $aihealue = Aihealue::haeYksi($id);
        View::make('aihealue.html', array('aihealue' => $aihealue));
    }
    
    
    public static function naytaLisays() {
        View::make('uusiAihealue.html');
    }

    public static function lisaaAihealue() {
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

}
