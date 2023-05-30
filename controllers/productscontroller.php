<?php

    class ProductsController
    {
        private $productModel;
        private $categoryModel;
        private $manufacturerModel;
        public $isAuthorized;

        public function __construct()
        {
            $this->productModel = new Product();
            $this->categoryModel = new Category();
            $this->manufacturerModel = new Manufacturer();
            $this->productModel = new Product();

            $userModel = new User();
            $this->isAuthorized = $userModel->checkIfUserAuthorized();

        }

        public function actionIndex($page = 1)
        {
            //Данные для пагинации
            $total = $this->productModel->getTotal();
            $limit = 10;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);
            $products = $this->productModel->getAllPaginated($limit, $offset);
            $title = 'Товары';
            include_once ("views/products/table.html");
        }

        public function actionAdd()
        {
            if (!$this->isAuthorized){
                include_once("views/errors/404NotFound.html");
                exit();
            }
            $errors = [];
            if (isset($_POST['product_name'])) {
                $nameProduct = htmlentities($_POST['product_name']);
                $priceProduct = htmlentities($_POST['product_price']);
                $availabilityProduct = htmlentities($_POST['product_availability']);
                $categoryProduct = htmlentities($_POST['product_category']);
                $manufacturerProduct = htmlentities($_POST['product_manufacturer']);
                $descriptionProduct = htmlentities($_POST['product_description']);
                //TODO: проверка на регулярки, стирание лишних пробелов, проверка на существование такой книги

                $data = array(
                    'name' => $nameProduct,
                    'price' => $priceProduct,
                    'availability' => $availabilityProduct,
                    'category' => $categoryProduct,
                    'manufacturer' => $manufacturerProduct,
                    'description' => $descriptionProduct
                );

                if (empty($errors)) {
                    $this->productModel->insert($data);
                    header('Location:' . FULL_SITE_ROOT . 'products');
                }
            }

            $manufacturers = $this->manufacturerModel->getAll();
            $categories = $this->categoryModel->getAll();
            $title = 'Добавление товара';
            include_once ("views/products/form.html");
        }

        public function actionEdit($id)
        {
            if (!$this->isAuthorized){
                include_once("views/errors/404NotFound.html");
                exit();
            }
            $errors = [];
            $product = $this->productModel->getById($id);
            //TODO: проверка, что данные с таким id существуют
            if (isset($_POST['product_name'])) {
                $nameProduct = htmlentities($_POST['product_name']);
                $priceProduct = htmlentities($_POST['product_price']);
                $availabilityProduct = htmlentities($_POST['product_availability']);
                $categoryProduct = htmlentities($_POST['product_category']);
                $manufacturerProduct = htmlentities($_POST['product_manufacturer']);
                $descriptionProduct = htmlentities($_POST['product_description']);
                //TODO: регулярки
                $data = array(
                    'name' => $nameProduct,
                    'price' => $priceProduct,
                    'availability' => $availabilityProduct,
                    'category' => $categoryProduct,
                    'manufacturer' => $manufacturerProduct,
                    'description' => $descriptionProduct
                );

                if (empty($errors)) {
                    if ($product === $data) {
                        header('Location:' . FULL_SITE_ROOT . 'products');
                    }
                    if ($product !== $data) {
                        //TODO: проверка, что таких данных уже нет в таблице
                        $result = $this->productModel -> edit($data, $id);
                        if ($result) {
                            header('Location:' . FULL_SITE_ROOT . 'products');
                        } else {
                            $errors[] = "Не удалось добавить данные в таблицу";
                        }
                    }
                }
            }
            $manufacturers = $this->manufacturerModel->getAll();
            $categories = $this->categoryModel->getAll();
            $title = 'Изменить данные товара';
            include_once ("views/products/form.html");
        }

        public function actionDelete($id)
        {
            if (!$this->isAuthorized){
                include_once("views/errors/404NotFound.html");
                exit();
            }
            $errors = [];
            //TODO: проверка, что id передан верно, и он существует
            $this->productModel->remove($id);
            header('Location:' . FULL_SITE_ROOT . 'products');
        }
    }
