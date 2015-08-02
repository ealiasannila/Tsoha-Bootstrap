<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on keskustelufoorumi';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä

        View::make('helloworld.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }
    public static function register() {
        View::make('suunnitelmat/register.html');
    }
    public static function newTopic() {
        View::make('suunnitelmat/newTopic.html');
    }
    public static function newReply() {
        View::make('suunnitelmat/newReply.html');
    }
    public static function subForum() {
        View::make('suunnitelmat/subForum.html');
    }
    public static function forum() {
        View::make('suunnitelmat/forum.html');
    }
    public static function topic() {
        View::make('suunnitelmat/topic.html');
    }
    public static function user() {
        View::make('suunnitelmat/user.html');
    }

}
