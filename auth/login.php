<?php

if(isset($_SESSION['user'])) {
    header('location: auth.php');
}



require_once 'connection.php';

if(isset($_POST['do_login'])) {
    $errors = [];

    $login = htmlspecialchars(trim($_POST['login']));
    $password = htmlspecialchars($_POST['password']);

    $user = R :: findOne(Config :: tablename, 'login = ?', [$login]);

    if($user) {
        if(password_verify($password, $user->password)) {
            $_SESSION['user'] = $user;
        }
        else {
            $errors[] = 'Неправильно введён пароль!';
        }
    }
    else {
        $errors[] = 'Пользователь с таким логином не найден!';
    }

    R :: close();

    if(!empty($errors)) {
        print_first_error($errors);
    }
    else {
        header('location: auth.php');
    }
}



function print_first_error(array $errors) {
    echo "<div id='first_error' style='color: red;'>
            {$errors[0]}
            <hr'>
          </div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<body>
    <form action="login.php" method="post">
        <p>
            <label for="login">Логин</label>
            <input type="text" name="login" id="login" required>
        </p>

        <p>
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>
        </p>

        <button type="submit" name="do_login">Войти</button>
    </form>
</body>
</html>