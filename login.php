<?php
session_start();

$host = "localhost";
$user = "root";
$dbpassword = "";
$dbname = "mydb";
$conn = new mysqli($host, $user, $dbpassword, $dbname);

if (!empty($_POST['login']) && !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        $id = $user['id'];
        $_SESSION['id'] = $id;
        header('Location: profile.php');
    } else {
        $message = "Неверный логин или пароль";
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/authentication.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card register-card">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4">Авторизация</h1>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-danger"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="login" class="form-label">Логин</label>
                            <input type="text"
                                   class="form-control"
                                   id="login"
                                   name="login"
                                   placeholder="Введите логин"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="Введите пароль"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-register btn-lg w-100 text-white mb-3">
                            Войти
                        </button>

                        <div class="text-center">
                            <p class="mb-0">Нет аккаунта? <a href="register.php" class="text-decoration-none">Войти</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

