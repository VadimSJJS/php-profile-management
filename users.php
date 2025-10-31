<?php
session_start();

// Проверяем авторизацию (опционально)
if (!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$dbpassword = "";
$dbname = "mydb";
$conn = mysqli_connect($host, $user, $dbpassword, $dbname);

if (!$conn) {
    die("Ошибка подключения к базе данных");
}

// Получаем всех пользователей
$query = "SELECT id, login, fullName, birthday FROM users ORDER BY login";
$result = mysqli_query($conn, $query);

// Функция для вычисления возраста
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
    <title>Список пользователей</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .users-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .user-link {
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }
        .user-link:hover {
            color: #0d6efd;
            background-color: #f8f9fa;
        }
        .user-item {
            border-bottom: 1px solid #eee;
            padding: 1rem;
            transition: background-color 0.3s ease;
        }
        .user-item:hover {
            background-color: #f8f9fa;
        }
        .user-item:last-child {
            border-bottom: none;
        }
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Список пользователей</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="profile.php">Мой профиль</a>
            <a class="nav-link" href="logout.php">Выйти</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card users-card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Все пользователи</h4>
                    <p class="text-muted mb-0">Нажмите на пользователя для просмотра профиля</p>
                </div>
                <div class="card-body p-0">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($user = mysqli_fetch_assoc($result)): ?>
                            <a href="user_profile.php?id=<?php echo $user['id']; ?>" class="user-link">
                                <div class="user-item d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <?php echo strtoupper(mb_substr($user['login'], 0, 1)); ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($user['fullName']); ?></h6>
                                        <p class="text-muted mb-1">Логин: <?php echo htmlspecialchars($user['login']); ?></p>
                                        <?php if (!empty($user['birthday']) && $user['birthday'] != '0000-00-00'): ?>
                                            <?php $age = getAge($user['birthday']); ?>
                                            <small class="text-muted">
                                                Дата рождения: <?php echo htmlspecialchars($user['birthday']); ?>
                                                <?php if ($age): ?> • <?php echo $age; ?> лет<?php endif; ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">ID: <?php echo $user['id']; ?></small>
                                        <div class="mt-1">
                                            <span class="badge bg-primary">Профиль →</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center p-4">
                            <p class="text-muted">Пользователи не найдены</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Статистика -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-center bg-light">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <?php
                                mysqli_data_seek($result, 0);
                                echo mysqli_num_rows($result);
                                ?>
                            </h5>
                            <p class="card-text">Всего пользователей</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>