<?php

    class Router
    {
        private $routes;

        public function __construct()
        {
            require_once("configs/routes.php");
            $this->routes = $routes;
        }

        public function run()
        {
            //Получаем адрес страницы, на которую перешел пользователь. Например, MVC_digital_technology/manufactuters
            $requestedUrl = $_SERVER['REQUEST_URI'];
            //Перебираем $routes как controllers (ManufacturerController, CategoryController и тд)
            foreach ($this->routes as $controller => $paths) {
                //У каждого контроллера есть путь. Перебираем этот массив как путь => action
                foreach ($paths as $url => $actionWithParameters) {
                    //Если находим совпадение url из routes в url, который ввел пользователь
                      if (preg_match("~$url~", $requestedUrl)) {
                    //Если путь совпадает с тем, что ввел пользователь из $_SERVER, значит определили нужный контроллер и его action
                    //if (SITE_ROOT . $url === $requestedUrl) {
                         //Получаем action с конкретным параметром.
                         $actionWithParameters = preg_replace("~$url~", $actionWithParameters, $requestedUrl);
                         $count = 1;
                         $actionWithParameters = str_replace(SITE_ROOT, '', $actionWithParameters, $count);
                         //Формируем массив. Отдельно action, отдельно параметр
                         $actionWithParametersArray = explode('/', $actionWithParameters);
                         //Передаем action в отдельную переменную и удаляем его и массива
                         $action = array_shift($actionWithParametersArray);
                        //Создаем экземпляр класса (название класса - нужный контроллер (ManufacturerController, CategoryController и тд))
                        $requestedController = new $controller();
                        //Присваиваем переменной имя нужного action в формате "actionIndex"
                        $requestedAction = "action" . ucfirst($action);
                        //Вызываем у объекта нужный метод (то есть мы получили нужный контроллер и нужный action)
                        //$requestedController->$requestedAction();

                        //Вызываем метод у объекта, передавая в этот метод параметры
                          call_user_func_array(array($requestedController, $requestedAction), $actionWithParametersArray);
                        //Завершаем первый foreach, когда получим нужный контроллер и action
                        break 2;
                    }

                }
            }
        }
    }
