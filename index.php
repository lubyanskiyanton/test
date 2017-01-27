<?php
// класс пользователя
class User {
    public function __construct($email) {
        $this->email = $email;
    }
    public function setLastName ($lastName) {
        $this->lastName = $lastName;
    }
    public function setFirstName ($firstName) {
        $this->firstName = $firstName;
    }
    public function setDate ($date) {
        $this->date = $date;
    }
    public function setMobile ($mobile) {
        $this->mobile = $mobile;
    }
    public function setEmail ($email) {
        $this->email = $email;
    }
    function setPassword ($password) {
        $this->password = $password;
    }
    public function getLastName () {
        return $this->lastName;
    }
    public function getFirstName () {
        return $this->firstName;
    }
    public function getDate () {
        return $this->date;
    }
    public function getMobile () {
        return $this->mobile;
    }
    public function getEmail () {
        return $this->email;
    }
    function getPassword () {
        return $this->password;
    }
    public function checkAuth ($password) {
        $db_hostname = "bill.ptk.ru";
        $db_database = "test";
        $db_username = "test";
        $db_password = "test";
        /*
         * таблица "users" - таблица с данными пользователей
         * lastName - text; Фамилия
         * firstName - text; Имя
         * date - DATE; Дата рождения
         * mobile - text; номер мобильного телефона
         * email -text; адрес электронной почты
         * password - text; пароль
         * id - int; идентификатор пользователя
         *
         */
        // подключаемся к БД
        $mysqli = new mysqli($db_hostname, $db_username, $db_password);
        if ($mysqli->connect_errno) {
            printf("Сервис временно недоступен. Попробуйте позже.");
            exit();
        }
        $mysqli->select_db($db_database);
        $mysqli->set_charset("utf8");
        $query = "SELECT `lastName`, `firstName`, `date`, `mobile`, `email`, `password`, `id` FROM `users` WHERE `email`=\"$this->email\"";
        if ($result = $mysqli->query($query)) {
            $tmp = $result->fetch_row();
            if ($password === $tmp[5]) {
                $this->lastName = $tmp[0];
                $this->firstName = $tmp[1];
                $this->date = $tmp[2];
                $this->mabile = $tmp[3];
                $this->id = $tmp[6];
                return true;
            }
            else {
                return false;
            }
        }
    }
    public function setIpAction ($action) {
        // добавляем данные об активности IP
        // параметры подключения к БД
        $db_hostname = "bill.ptk.ru";
        $db_database = "test";
        $db_username = "test";
        $db_password = "test";
        /*
         * таблица "users" - таблица с данными пользователей
         * lastName - text; Фамилия
         * firstName - text; Имя
         * date - DATE; Дата рождения
         * mobile - text; номер мобильного телефона
         * email -text; адрес электронной почты
         * password - text; пароль
         * id - int; идентификатор пользователя
         *
         * таблица ipStat - таблица статистики ip
         * userId - int; идентификатор пользователя
         * action - text; действие: регистрация или авторизация
         * ip - text; ip адрес
         * date - timestamp; метка времени
         */
        // подключаемся к БД
        $mysqli = new mysqli($db_hostname, $db_username, $db_password);
        if ($mysqli->connect_errno) {
            printf("Сервис временно недоступен. Попробуйте позже.");
            exit();
        }
        $mysqli->select_db($db_database);
        $mysqli->set_charset("utf8");
        $query = "SELECT `id` FROM `users` WHERE `email`=\"$this->email\"";
        if ($result = $mysqli->query($query)) {
            $tmp = $result->fetch_row();
            $userId = $tmp[0];
            $ip = $_SERVER['REMOTE_ADDR'];
            $query = "INSERT INTO `ipStat`(`userId`, `action`, `ip`) VALUES (\"$userId\", \"$action\", \"$ip\")";
            $mysqli->query($query);
        }
    }
}

// параметры подключения к БД
$db_hostname = "bill.ptk.ru";
$db_database = "test";
$db_username = "test";
$db_password = "test";
/*
 * таблица "users" - таблица с данными пользователей
 * lastName - text; Фамилия
 * firstName - text; Имя
 * date - DATE; Дата рождения
 * mobile - text; номер мобильного телефона
 * email -text; адрес электронной почты
 * password - text; пароль
 * id - int; идентификатор пользователя
 *
 * таблица ipStat - таблица статистики ip
 * userId - int; идентификатор пользователя
 * action - text; действие: регистрация или авторизация
 * ip - text; ip адрес
 * date - timestamp; метка времени
 */
// подключаемся к БД
$mysqli = new mysqli($db_hostname, $db_username, $db_password);
if ($mysqli->connect_errno) {
    printf("Сервис временно недоступен. Попробуйте позже.");
    exit();
}
$mysqli->select_db($db_database);
$mysqli->set_charset("utf8");

if (!empty($_GET['action']) && ($_GET['action'] === 'enter' || $_GET['action'] === 'registration')) {
    $action = $_GET['action'];
    if (!empty($_GET['email']) && !empty($_GET['password'])) {
        if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_GET['email'];
            if (preg_match('/^[a-zA-Z0-9@!#$]{8,}$/',$_GET['password'])) {
                $password = $_GET['password'];
                switch ($action) {
                    case "registration": // регистрация нового пользователя
                        if (!empty($_GET['lastName']) && !empty($_GET['firstName'])) {
                            if (preg_match('/^[a-zA-Zа-яА-Я]+$/', $_GET['lastName']) && preg_match('/^[a-zA-Zа-яА-Я]+$/', $_GET['firstName'])) {
                                $lastName = $_GET['lastName'];
                                $firstName = $_GET['firstName'];
                                if (!empty($_GET['date']) && preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_GET['date'])) { //если указана дата
                                    $date = $_GET['date'];
                                }
                                if (!empty($_GET['mobile']) && preg_match('/^\+7-[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/', $_GET['mobile'])) { //если указан мобильный номер
                                    $mobile = $_GET['mobile'];
                                }
                                // проверяем время последней регистрации с данного IP
                                $query = "SELECT MAX(`date`) FROM `ipStat` WHERE `ip` LIKE \"". $_SERVER['REMOTE_ADDR'] . "\" AND `action`=\"registration\" GROUP BY `ip`";
                                if ($result = $mysqli->query($query)) {
                                    $tmp = $result->fetch_row();
                                    $lastDate = strtotime($tmp[0]);
                                    if (($lastDate + 600) > time()) {
                                        $script .= "window.alert(\"Регистрация с одного IP, чаще 10 минут - ЗАПРЕЩЕНА!\");";
                                    }
                                    else {
                                        // создаем пользователя
                                        $user = new User();
                                        $user->setLastName($lastName);
                                        $user->setFirstName($firstName);
                                        $user->setEmail($email);
                                        $user->setPassword($password);
                                        if (!empty($date)) {
                                            $user->setDate($date);
                                        }
                                        if (!empty($mobile)) {
                                            $user->setMobile($mobile);
                                        }
                                        // запрос на добавление записи в БД
                                        $query = "INSERT INTO `users`(`lastName`, `firstName`, `date`, `mobile`, `email`, `password`) VALUES (\"$lastName\", \"$firstName\", \"$date\", \"$mobile\", \"$email\", \"$password\")";
                                        if ($result = $mysqli->query($query)) {
                                            $script .= "window.alert(\"Регистрация прошла успешно!\");";
                                            $user->setIpAction($action); // записываем действие
                                        }
                                        else {
                                            $script .= "window.alert(\"Ошибка регистрации пользователя!\");";
                                        }
                                    }
                                }
                            }
                            else {
                                $script .= "window.alert(\"Фамилия и имя могут содержать только буквы.\");";
                            }
                        }
                        else {
                            $script .= "window.alert(\"Указаны не все данные.\");";
                        }
                        break;
                    case "enter":
                        // авторизация пользователя
                        $user = new User($email);
                        if ($user->checkAuth($password)) {
                            $script .= "window.alert(\"Авторизация прошла успешно.\");";
                            $user->setIpAction($action); // записываем действие
                        }
                        else {
                            $script .= "window.alert(\"Неверный логин/пароль.\");";
                        }
                }
            }
            else {
                $script .= "window.alert(\"Некорректный пароль. Пароль должен быть не менее 8 символов и может содержать латинские буквы, цыфры и символы: !, @, #, $.\");";
            }
        }
        else {
            $script .= "window.alert(\"Некорректный email.\");";
        }
    }
    else {
        $script .= "window.alert(\"Не указан логин/пароль.\");";
    }
}
?>

<html>
<head>
    <title>Тестовое задание, страница входа/регистрации</title>
    <meta charset="utf-8" />
    <style>
        div#form {
            border: 1px solid #999;
            margin: -1px 0 0 0;
            padding: 20px;
        }
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        ul li {
            display: inline-block;
            border: 1px solid #999;
            border-bottom: 0 none;
            line-height: 30px;
        }
        ul li a {
            display: block;
            color: #666;
            text-decoration: none;
            display: inline-block;
            padding: 0px 12px;
            white-space: nowrap;
        }
        ul li a:hover {
            border-bottom: none;
        }
        ul li a.tab {
            border-bottom: 1px solid #999;
            height: 29px;
            background: #eee;
        }
        /*выделяем активную вкладку*/
        ul li a.activ-tab {
            background: #fff;
            border-bottom: 0 none;
        }
    </style>
</head>
<body>
<div id="main" style="width: 600px; margin: 0 auto; text-align: center">
    <h1>Тестовое задание</h1>
    <h2>Страница для входа или регистрации пользователей</h2>
    <ul>
        <li><a href="#enter" id="tab-enter" class="activ-tab">Вход</a></li>
        <li><a href="#registration" id="tab-reg" class="tab">Регистрация</a></li>
    </ul>
    <div id="form">
        <div id="enter">
            <h3>Вход для зарегистрированных пользователей:</h3>
            <form>
                Введите:
                <table style=" width: 300px; margin: auto">
                    <tr> <td>e-mail:</td> <td> <input type="email" name="email" placeholder="example@mail.com" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required /> </td> </tr>
                    <tr> <td>пароль:</td> <td> <input type="password" name="password" id="passwordEnter" required /> </td> </tr>
                </table>
                <input type="hidden" name="action" value="enter" />
                <input type="submit" value="Вход" />
            </form>
        </div>
        <div id="registration">
            <h3>Регистрация нового пользователя:</h3>
            <form onsubmit="return submitReg();">
                Введите:
                <table style=" width: 300px; margin: auto">
                    <tr> <td>Фамилия*:</td> <td> <input type="text" name="lastName" placeholder="Лубянский" pattern="^[a-zA-ZА-Яа-я]+$" required /></td> </tr>
                    <tr> <td>Имя*:</td> <td> <input type="text" name="firstName" placeholder="Антон" pattern="^[a-zA-ZА-Яа-я]+$" required /></td> </tr>
                    <tr> <td>Дата рождения:</td> <td> <input type="date" name="date" /></td> </tr>
                    <tr> <td>Мобильный телефон:</td> <td> <input type="tel" name="mobile" placeholder="+7-911-769-87-77" pattern="^\+7-[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$" /></td> </tr>
                    <tr> <td>e-mail*:</td> <td> <input type="email" name="email" placeholder="example@mail.com" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required /> </td> </tr>
                    <tr> <td>пароль*:</td> <td> <input type="password" name="password" id="passwordReg" required /> </td> </tr>
                    <tr> <td>еще раз<br />пароль*:</td> <td> <input type="password" name="confPassword" id="passwordConfReg" required /> </td> </tr>
                </table>
                <input type="hidden" name="action" value="registration" />
                <input type="submit" value="Регистрация" />
            </form>
        </div>
    </div>
</div>

<script src="jquery-3.1.1.min.js"></script>
<script>
    $('document').ready(function(){ // действия когда страница загружена
        <?php echo $script; ?>
        $('#enter').show();
        $('#registration').hide();
    });
    $('#tab-enter').click(function(){ // действия когда кликают на вкладку ВХОД
        $('#enter').show();
        $('#registration').hide();
        $('#tab-enter').removeClass('tab').addClass('activ-tab');
        $('#tab-reg').removeClass('activ-tab').addClass('tab');
    });
    $('#tab-reg').click(function(){ // действия когда кликают на вкладку РЕГИСТРАЦИЯ
        $('#enter').hide();
        $('#registration').show();
        $('#tab-enter').removeClass('activ-tab').addClass('tab');
        $('#tab-reg').removeClass('tab').addClass('activ-tab');
    });
    // функция проверки формы регистрации пользователя
    function submitReg() {
        // проверяем совпадают ли введенные пароли
        if ($('#passwordReg').val() != $('#passwordConfReg').val()) {
            window.alert("Введенные пароли не совпадают!");
            $('#passwordReg').focus();
            return false;
        }
        return true;
    }
</script>

</body>
</html>
