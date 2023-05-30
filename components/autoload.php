<?php
    //Функция автоматически вызывается при обращении к классу (созданию экземпляра). В callback в качестве аргумента передается имя этого класса. Если файл с таким классом есть, то он подключается
    spl_autoload_register(function ($class){
        $dirs = ['components', 'controllers', 'models'];
        foreach ($dirs as $dir) {
            $fileName = "$dir/" . mb_strtolower($class) . ".php";
            if (file_exists($fileName)) {
                require_once ("$fileName");
            }
        }

    });
