<?php

require_once 'connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сайт</title>
</head>
<body>
    <p>
        Авторизован как <strong><?php echo (isset($_SESSION['user'])) ? $_SESSION['user']->login : 'Гость' ?></strong>
    </p>

    <?php

    if(!isset($_SESSION['user'])) {
        echo '<p>
                <a href="login.php">Авторизация</a>
              </p>
              <p>
                <a href="signup.php">Регистрация</a>
              </p>';
    }
    else {
        echo '<p>
                <a href="logout.php">Выход</a>
              </p>';
    }

    ?>
</body>
</html>