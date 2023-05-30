<?php
    //При переходе по любому url происходит редирект на этот файл

    require_once("components/autoload.php");
    require_once ("configs/constants.php");

    //При обращении к сайту, создается объект, у которого вызывается метод
    $router = new Router();
    $router->run();
