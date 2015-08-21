<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['user'])) {
            $kayttaja_id = $_SESSION['user'];
            $kayttaja = Kayttaja::haeYksi($kayttaja_id);

            return $kayttaja;
        }

        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/kirjaudu', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

    public static function check_yllapito() {
        self::check_logged_in();

        $kayttaja = self::get_user_logged_in();
        if (!$kayttaja->kuuluuRyhmaan(1)) {
            Redirect::to('/');
        }
    }

}
