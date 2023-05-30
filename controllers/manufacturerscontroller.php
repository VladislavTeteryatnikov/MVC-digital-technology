<?php

    class ManufacturersController
    {
        //Создаем конструктор, в котором сразу в свойстве $manufacturerModel будет создаваться объект Manufacturer
        private $manufacturerModel;
        private $checkErrors;
        public $isAuthorized;

        public function __construct()
        {
            $this->manufacturerModel = new Manufacturer();
            $this->checkErrors = new Errors();
            $userModel = new User();
            $this->isAuthorized = $userModel->checkIfUserAuthorized();
        }

        public function actionIndex($page = 1)
        {
            //Данные для пагинации
            $total = $this->manufacturerModel->getTotal();
            $limit = 10;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);
            //Контроллер обращается к модели, чтобы забрать у нее данные и передать в представление
            $manufacturers = $this->manufacturerModel->getAllPaginated($limit, $offset);
            $title = 'Производители';
            include_once("views/manufacturers/table.html");
        }

        public function actionAdd()
        {
            if (!$this->isAuthorized){
                include_once("views/errors/404NotFound.html");
                exit();
            }
            $errors = [];
            if (isset($_POST['name_manufacturer'])) {
                $nameManufacturer = htmlentities($_POST['name_manufacturer']);
//                if ($this->checkErrors->checkLength($nameManufacturer) || $this->checkErrors->manufacturerNameCheck($nameManufacturer)) {
//                    $errors[] = 'Некорректно заполнено поле "Название производителя"';
//                } else {
//                    $manufacturers = $this->manufacturerModel -> getAll();
//                    foreach ($manufacturers as $manufacturer) {
//                        if ($manufacturer['manufacturer_name'] === $nameManufacturer) {
//                            $errors[] = 'Такой производитель уже существует';
//                            break;
//                        }
//                    }
                //TODO: проверка на регулярки +
                //TODO: проверка, что таких данных уже нет в таблице +
                if (empty($errors)) {
                    $this->manufacturerModel->insert($nameManufacturer);
                    header('Location:' . FULL_SITE_ROOT . 'manufacturers');
                }
            }

            $title = 'Добавить производителя';
            include_once("views/manufacturers/form.html");
        }

        public function actionEdit($id)
        {
            if (!$this->isAuthorized){
                include_once("views/errors/404NotFound.html");
                exit();
            }
            $errors = [];
            $manufacturer = $this->manufacturerModel->getById($id);
            if (isset($_POST['name_manufacturer'])) {
                $nameManufacturer = htmlentities($_POST['name_manufacturer']);
                //TODO: проверка на регулярки
                if (empty($errors)) {
                    if ($manufacturer['manufacturer_name'] === $nameManufacturer) {
                        header('Location:' . FULL_SITE_ROOT . 'manufacturers');
                    }
                    if ($manufacturer['manufacturer_name'] !== $nameManufacturer) {
                        //TODO: проверка, что таких данных уже нет в таблице
                        $result = $this->manufacturerModel -> edit($nameManufacturer, $id);
                        if ($result) {
                            header('Location:' . FULL_SITE_ROOT . 'manufacturers');
                        } else {
                            $errors[] = "Не удалось добавить данные в таблицу";
                        }
                    }

                }
            }
            $title = 'Изменить данные производителя';
            include_once("views/manufacturers/form.html");
        }

        public function actionDelete($id)
        {
            if (!$this->isAuthorized){
                include_once("views/errors/404NotFound.html");
                exit();
            }
                $errors = [];
                //TODO: проверка, что id передан верно, и он существует
                $this->manufacturerModel->remove($id);
                header('Location:' . FULL_SITE_ROOT . 'manufacturers');
        }

    }
