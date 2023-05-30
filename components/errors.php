<?php

    class Errors
    {

        public function checkLength($string, $lengthMax = 255, $lengthMin = 2)
        {
            if (mb_strlen($string) >= $lengthMax || mb_strlen($string) < $lengthMin) {
                return true;
            }
        }

        public function manufacturerNameCheck($nameManufacturer)
        {
            if (!preg_match("~^[\w'&\- ]+$~ui", $nameManufacturer)) {
                return true;
            }
        }

        public function emailCheck($email)
        {
            if (!preg_match("~^[\w\.%+-]+@[a-z0-9-]+\.[a-z]{2,4}$~i", $email)) {
                return true;
            }
        }

        public function passwordCheck($password)
        {
            if (!preg_match("~^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]$~", $password)) {
                return true;
            }
        }

        public function showErrors(array $errors)
        {
            foreach ($errors as $error) {
                return $error;
            }
        }
    }
