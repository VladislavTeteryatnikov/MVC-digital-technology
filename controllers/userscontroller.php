<?php

    class UsersController
    {
        private $userModel;
        private $helper;
        public $isAuthorized;

        public function __construct()
        {
            $this->userModel = new User();
            $this->helper = new Helper();
            $this->isAuthorized = $this->userModel->checkIfUserAuthorized();
        }

        public function actionReg()
        {
            $errors = [];
            //Проверяем, что форма отправлена и присваиваем значения переменным
            if (isset($_POST['email'])) {
                $email = htmlentities($_POST['email']);
                $password = htmlentities($_POST['password']);
                $repeatPassword = htmlentities($_POST['repeat_password']);
                //TODO: проверка на регулярки
                //Проверяем, что пользователь ввел оба раза одинаковый пароль
                if ($password !== $repeatPassword) {
                    $errors[] = "Пароли не совпадают";
                } else {
                    $count = $this->userModel->checkIfUserExists($email);
                    //Если нашлось совпадение, то выводим ошибку
                    if ((int)$count === 1) {
                        $errors[] = "Такой email уже зарегистрирован";
                    }
                    if (empty($errors)) {
                        //Хэшируем пароль и вносим данные пользователя в БД
                        $hashedPassword = md5($password);
                        $this->userModel->register($email, $hashedPassword);

                        $token = $this->helper->generateToken();
                        $tokenTime = time() + 30 * 60;
                        $userInfo = $this->userModel->getUserInfo($email, $hashedPassword);
                        $userId = $userInfo['user_id'];
                        $this->userModel->auth($userId, $token, $tokenTime);

                        setcookie("uid", $userId, time() + 2 * 24 * 3600, '/');
                        setcookie("t", $token, time() + 2 * 24 * 3600, '/');
                        setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, '/');

                        header('Location:' . FULL_SITE_ROOT . 'products');
                    }
                }
            }
            $title = 'Регистрация';
            include_once("views/users/reg.html");
        }

        public function actionAuth()
        {
            $errors = [];
            //Проверяем, что форма отправлена и присваиваем значения переменным
            if (isset($_POST['email'])) {
                $email = htmlentities($_POST['email']);
                $password = htmlentities($_POST['password']);
                //TODO: регулярки
                //Хэшируем пароль для запроса к БД
                $hashedPassword = md5($password);
                $userInfo = $this->userModel->getUserInfo($email, $hashedPassword);
                if ($userInfo['count'] === '0') {
                    $errors[] = "Такой связки email / пароль не существует";
                }
                //Если ошибок нет
                if (empty($errors)) {
                    //Генерируем токен и время жизни этого токена
                    $token = $this->helper->generateToken();
                    $tokenTime = time() + 30 * 60;
                    //Забираем id пользователя, если он прошел авторизацию
                    $userId = $userInfo['user_id'];
                    $this->userModel->auth($userId, $token, $tokenTime);
                    //Создаем новые куки
                    setcookie("uid", $userId, time() + 2 * 24 * 3600, '/');
                    setcookie("t", $token, time() + 2 * 24 * 3600, '/');
                    setcookie("tt", $tokenTime, time() + 2 * 24 * 3600, '/');
                    header('Location:' . FULL_SITE_ROOT . 'products');;

                }
            }
            $title = 'Авторизация';
            include_once("views/users/auth.html");
        }

        public function actionLogout()
        {
            $this->userModel->logout();
            setcookie("uid", "", time() - 10, '/');
            setcookie("t", "", time() - 10, '/');
            setcookie("tt", 0, time() - 10, '/');
            header('Location:' . FULL_SITE_ROOT . 'products');;
        }

    }

