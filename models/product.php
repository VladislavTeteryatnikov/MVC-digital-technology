<?php

    class Product
    {
        private $connect;

        public function __construct()
        {
            $this->connect = DB::getConnect();
        }

        public function getAll()
        {
            $query = "
                SELECT `product_id`, `product_name`, `category_name`, `product_price`, `manufacturer_name`, `product_availability`, `product_description`
                FROM `products`
                LEFT JOIN `categories` ON `product_category_id` = `category_id`
                LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
                WHERE `product_is_deleted` = 0
                ORDER BY `product_id` DESC; 
            ";
           $result = mysqli_query($this->connect, $query);
           return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function getAllPaginated($limit, $offset)
        {
            $query = "
                SELECT `product_id`, `product_name`, `category_name`, `product_price`, `manufacturer_name`, `product_availability`, `product_description`
                FROM `products`
                LEFT JOIN `categories` ON `product_category_id` = `category_id`
                LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
                WHERE `product_is_deleted` = 0
                ORDER BY `product_id` DESC
                LIMIT $offset, $limit; 
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function insert(array $data)
        {
            $query = "
                INSERT INTO `products`
                    SET `product_name` = '$data[name]',
                        `product_price` = $data[price],
                        `product_availability` = $data[availability],
                        `product_manufacturer_id` = $data[manufacturer],
                        `product_category_id` = $data[category],
                        `product_description` = '$data[description]';
            ";
            return mysqli_query($this->connect, $query);
        }

        public function getById($id)
        {
            $query = "
                SELECT `product_name`, `product_category_id`, `product_price`, `product_manufacturer_id`, `product_availability`, `product_description`
                FROM `products`
                WHERE `product_id` = '$id'; 
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        public function edit(array $data, int $id)
        {
            $query = "
                UPDATE `products`
                SET `product_name` = '$data[name]',
                    `product_price` = $data[price],
                    `product_availability` = $data[availability],
                    `product_manufacturer_id` = $data[manufacturer],
                    `product_category_id` = $data[category],
                    `product_description` = '$data[description]'
                WHERE `product_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        public function remove($id)
        {
            $query = "
                UPDATE `products`
                SET `product_is_deleted` = 1
                WHERE `product_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        public function getTotal()
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `products`
                WHERE `product_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }

    }