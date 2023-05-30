<?php

    class Manufacturer
    {
        //При создании экземпляра, в конструкторе сразу происходит подключение к БД
        private $connect;

        public function __construct()
        {
            $this->connect = DB::getConnect();
        }

        public function getAll()
        {
            $query = "
                SELECT * 
                FROM `manufacturers`
                WHERE `manufacturer_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function getAllPaginated($limit, $offset)
        {
            $query = "
                SELECT * 
                FROM `manufacturers`
                WHERE `manufacturer_is_deleted` = 0
                LIMIT $offset, $limit;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function insert($name_manufacturer)
        {
            $query = "
                INSERT INTO `manufacturers`
                SET `manufacturer_name` = '$name_manufacturer'
            ";
            return mysqli_query($this->connect, $query);
        }

        public function getById($id)
        {
            $query = "
                SELECT `manufacturer_name`
                FROM `manufacturers`
                WHERE `manufacturer_id` = $id
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        public function edit($nameManufacturer, $id)
        {
            $query = "
                UPDATE `manufacturers`
                SET `manufacturer_name` = '$nameManufacturer'
                WHERE `manufacturer_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        public function remove($id)
        {
            $query = "
                UPDATE `manufacturers`
                SET `manufacturer_is_deleted` = 1
                WHERE `manufacturer_id` = $id;
            ";
            return mysqli_query($this->connect, $query);
        }

        public function getTotal()
        {
            $query = "
                SELECT COUNT(*) AS `count`
                FROM `manufacturers`
                WHERE `manufacturer_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }

    }
