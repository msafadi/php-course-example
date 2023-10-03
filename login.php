<?php
session_start();

require_once __DIR__ . '/includes/connection.php';
require_once __DIR__ . '/includes/functions.php';

if ($_POST) {

    $attempts = $_COOKIE['login_attempts'] ?? 0;

    if ($attempts >= 5) {
        $errors['email'] = 'Too many login attempts please try later..';
    } else {

        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':email' => $_POST['email']
        ]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if ($user && password_verify($_POST['password'], $user->password)) {
            $_SESSION['auth'] = $user;

            // Remove cookie
            setcookie('login_attempts', '', time() - 60 * 60 * 24);

            redirect('users/index.php');
        }
        $errors['email'] = 'Invalid credentials';
    }

    $attempts++;
    setcookie('login_attempts', $attempts, time() + 60 * 1);
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mb-5">Login</h1>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                <?php if (isset($errors['email'])) : ?>
                <p class="text-danger"><?= $errors['email'] ?></p>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="">
                <?php if (isset($errors['password'])) : ?>
                <p class="text-danger"><?= $errors['password'] ?></p>
                <?php endif ?>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            attempts: <?= $attempts ?? 0 ?>
        </form>
    </div>
</body>
</html>