<?php

    class CategoriesController
    {
        private $categoryModel;
        private $checkErrors;
        public $isAuthorized;

        public function __construct()
        {
            $this->categoryModel = new Category();
            $this->checkErrors = new Errors();
            $userModel = new User();
            $this->isAuthorized = $userModel->checkIfUserAuthorized();
        }

        public function actionIndex($page = 1)
        {
            //Данные для пагинации
            $total = $this->categoryModel->getTotal();
            $limit = 10;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);
            $categories = $this->categoryModel->getAllPaginated($limit, $offset);
            $title = 'Категории';
            include_once ("views/categories/table.html");

        }

        public function actionAdd()
        {
            if (!$this->isAuthorized){
                include_once("views/errors/404NotFound.html");
                exit();
            }
            $errors = [];
            if (isset($_POST['category_name'])) {
                $nameCategory = htmlentities($_POST['category_name']);
                //TODO: проверка на регулярки
                //TODO: проверка, что таких данных уже нет в таблице

                if (empty($errors)) {
                    $this->categoryModel->insert($nameCategory);
                    header('Location:' . FULL_SITE_ROOT . 'categories');
                }
            }
            $title = 'Добавить категорию';
            include_once ("views/categories/form.html");
        }

        public function actionEdit($id)
        {
            if (!$this->isAuthorized){
                include_once("views/errors/404NotFound.html");
                exit();
            }
            $errors = [];
            $category = $this->categoryModel->getById($id);
            if (isset($_POST['category_name'])){
                $nameCategory = htmlentities($_POST['category_name']);
                //TODO: проверка на регулярки
                if (empty($errors)){
                    if ($category['category_name'] === $nameCategory){
                        header('Location:' . FULL_SITE_ROOT . 'categories');
                    }
                    if ($category['category_name'] !== $nameCategory) {
                        //TODO: проверка, что таких данных уже нет в таблице
                        $result = $this->categoryModel->edit($nameCategory, $id);
                        if ($result) {
                            header('Location:' . FULL_SITE_ROOT . 'categories');
                        } else {
                            $errors[] = "Не удалось добавить данные в таблицу";
                        }
                    }
                }

            }
            $title = 'Изменить категорию';
            include_once ("views/categories/form.html");
        }

        public function actionDelete($id)
        {
            $errors = [];
            //TODO: проверка, что id передан верно, и он существует
            $this->categoryModel->remove($id);
            header('Location:' . FULL_SITE_ROOT . 'categories');
        }

    }
