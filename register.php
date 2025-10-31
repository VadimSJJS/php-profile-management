<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "mydb";
$conn = new mysqli($host, $user, $pass, $dbname);

if (!empty($_POST['login']) and !empty($_POST['password'])
        and !empty($_POST['fullName']) and !empty($_POST['birthday'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $fullName = $_POST['fullName'];
    $birthday = $_POST['birthday'];

    $query = "INSERT INTO 
    users (login, password, fullName, birthday) 
    VALUES ('$login', '$password', '$fullName', '$birthday')";

    mysqli_query($conn, $query);
    $id = mysqli_insert_id($conn);
    $_SESSION['id'] = $id;
    header('Location: profile.php');
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/authentication.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card register-card">
                <div class="card-body p-5">
                    <h1 class="text-center mb-4">Регистрация</h1>

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

                        <div class="mb-3">
                            <label for="fullName" class="form-label">ФИО</label>
                            <input type="text"
                                   class="form-control"
                                   id="fullName"
                                   name="fullName"
                                   placeholder="Введите ваше полное имя"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="birthday" class="form-label">Дата рождения</label>
                            <input type="date"
                                   class="form-control"
                                   id="birthday"
                                   name="birthday"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-register btn-lg w-100 text-white mb-3">
                            Зарегистрироваться
                        </button>

                        <div class="text-center">
                            <p class="mb-0">Уже есть аккаунт? <a href="login.php" class="text-decoration-none">Войти</a>
                            </p>
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

