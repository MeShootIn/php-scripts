<?php

require_once 'connection.php';

if(isset($_POST['do_signup'])) {
    $errors = [];

    $login = htmlspecialchars(trim($_POST['login']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    if($login === '') {
        $errors[] = 'Неправильно введён логин!';
    }

    if($password === '') {
        $errors[] = 'Неправильно введён пароль!';
    }

    if(R :: count(Config :: tablename, 'login = ?', [$login]) > 0) {
        $errors[] = 'Пользователь с таким логином уже есть!';
    }
    elseif(R :: count(Config :: tablename, 'email = ?', [$email]) > 0) {
        $errors[] = 'Пользователь с таким email уже есть!';
    }
    elseif($password !== $confirm_password) {
        $errors[] = 'Пароли не совпадают!';
    }

    if(!empty($errors)) {
        print_first_error($errors);
    }
    else {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $user = R :: dispense(Config :: tablename);
        $user->login = $login;
        $user->email = $email;
        $user->password = $password;
        R :: store($user);

        $_SESSION['user'] = $user;
    }

    R :: close();

    if(isset($_SESSION['user'])) {
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
    <title>Регистрация</title>
</head>
<body>
    <form action="signup.php" method="post">
        <p>
            <label for="login">Ваш логин</label>
            <input type="text" name="login" id="login" required value=<?php echo @$_POST['login']; ?>>
        </p>

        <p>
            <label for="email">Ваш email</label>
            <input type="email" name="email" id="email" required value=<?php echo @$_POST['email']; ?>>
        </p>

        <p>
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>
        </p>

        <p>
            <label for="confirm_password">Повторите пароль</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </p>

        <button type="submit" name="do_signup">Зарегистрироваться</button>
    </form>
</body>
</html>