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
class AihealueController {

    public static function listaa() {

        $aihealue = Aihealue::haeYksi(1);
        View::make('aihealue.html', array('aihealue' => $aihealue));
    }

}
