<?php

    class Helper
    {
        public function generateToken($size = 32) {
            //Символы, которые могут содержаться в токене
            $symbols = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g'];
            $symbolsLength = count($symbols);
            //Создаем пустой токен
            $token = "";
            //Записываем в токен рандомные символы из $symbols
            for ($i = 0; $i < $size; $i++) {
                $token .= $symbols[rand(0, $symbolsLength - 1)];
            }
            return $token;
        }
    }
