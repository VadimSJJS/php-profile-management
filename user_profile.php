<?php
session_start();

$host = "localhost";
$user = "root";
$dbpassword = "";
$dbname = "mydb";
$conn = mysqli_connect($host, $user, $dbpassword, $dbname);

if (!$conn) {
    die("Ошибка подключения к базе данных");
}

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("Пользователь не найден");
}

function getAge($birthday) {
    if (empty($birthday) || $birthday == '0000-00-00') return null;

    $birth_timestamp = strtotime($birthday);
    $age = date('Y') - date('Y', $birth_timestamp);

    if (date('md') < date('md', $birth_timestamp)) {
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
    <style>
        .profile-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 2rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Профиль пользователя</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="users.php">← Назад к списку</a>
            <a class="nav-link" href="profile.php">Мой профиль</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card profile-card">
                <div class="profile-header text-center">
                    <h2 class="mb-2"><?php echo htmlspecialchars($user['fullName']); ?></h2>
                    <p class="mb-0 opacity-75">Профиль пользователя</p>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong>Логин:</strong> <?php echo htmlspecialchars($user['login']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>ФИО:</strong> <?php echo htmlspecialchars($user['fullName']); ?>
                    </div>
                    <?php if (!empty($user['birthday']) && $user['birthday'] != '0000-00-00'): ?>
                        <div class="mb-3">
                            <strong>Дата рождения:</strong>
                            <?php echo htmlspecialchars($user['birthday']); ?>
                            <?php $age = getAge($user['birthday']); ?>
                            <?php if ($age): ?>(<?php echo $age; ?> лет)<?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <strong>ID пользователя:</strong> <?php echo $user['id']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>