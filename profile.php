<?php
session_start();

$host = "localhost";
$user = "root";
$dbpassword = "";
$dbname = "mydb";
$conn = mysqli_connect($host, $user, $dbpassword, $dbname);
$id = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$age= getAge($user['birthday']);

function getAge($birthday) {
    if (empty($birthday)) return 'Не указана';

    list($year, $month, $day) = explode('-', $birthday);

    $today_year = date('Y');
    $today_month = date('m');
    $today_day = date('d');

    $age = $today_year - $year;

    if ($today_month < $month || ($today_month == $month && $today_day < $day)) {
        $age--;
    }

    return $age;
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Профиль пользователя</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/authentication.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>


<div class="container py-4">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded-3 mb-4 shadow">
        <div class="container">
            <a class="navbar-brand nav-brand" href="#">
                <i class="fas fa-user-circle me-2"></i>Мой Профиль
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-users me-1"></i>Список пользователей
                </a>
                <a class="nav-link active" href="profile.php">
                    <i class="fas fa-id-card me-1"></i>Профиль
                </a>
            </div>
        </div>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card profile-card">
                <div class="profile-header text-center">
                    <div class="avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2 class="mb-2"></h2>
                    <p class="mb-0 opacity-75">Пользователь</p>
                </div>

                <div class="card-body p-4">
                    <div class="info-item">
                        <div class="info-label">Логин</div>
                        <div class="info-value"><?= $user['login'] ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">ФИО</div>
                        <div class="info-value"><?= $user['fullName'] ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Возраст</div>
                        <div class="info-value"><?= $age ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>