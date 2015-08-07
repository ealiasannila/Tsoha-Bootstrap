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
class AiheController {

    public static function listaa() {

        $aihe = Aihe::haeYksi(1);
        
        View::make('aihe.html', array('aihe' => $aihe));
    }

}
