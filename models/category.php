<?php

    class Category
    {
        private $connect;

        public function __construct()
        {
            $this->connect = DB::getConnect();
        }

        public function getAll()
        {
            $query = "
                SELECT * 
                FROM `categories`
                WHERE `category_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function getAllPaginated($limit, $offset)
        {
            $query = "
                SELECT * 
                FROM `categories`
                WHERE `category_is_deleted` = 0
                LIMIT $offset, $limit;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function insert($nameCategory)
        {
            $query = "
                INSERT INTO `categories`
                SET `category_name` = '$nameCategory'
            ";
            return mysqli_query($this->connect, $query);
        }

        public function getById($id)
        {
            $query = "
                SELECT `category_name`
                FROM `categories`
                WHERE `category_id` = $id;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        public function edit($nameCategory, $id)
        {
            $query = "
                UPDATE `categories`
                SET `category_name` = '$nameCategory'
                WHERE `category_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        public function remove($id)
        {
            $query = "
                UPDATE `categories`
                SET `category_is_deleted` = 1
                WHERE `category_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        public function getTotal()
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `categories`
                WHERE `category_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }

    }
