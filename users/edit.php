<?php
    session_start();

    include __DIR__ . '/../includes/functions.php';

    if (!isset($_SESSION['auth'])) {
        redirect('../login.php');
    }
    
    require_once __DIR__ . '/../includes/connection.php';

    $id = $_REQUEST['id'] ?? 0;
    if (!$id) {
        header('Location: index.php');
        exit;
    }

    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':id' => $id,
    ]);
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$user) {
        die('User not found');
    }

    $errors = [];

    if ( strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ) {
        $errors = validate_user($_POST);

        if (!$errors) {
            $sql = 'UPDATE users SET
                name = :name,
                email = :email
                WHERE id = :id';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // PRG
            redirect('index.php?success=User+Updated');
        }
    }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Edit User</h1>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $user->id ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $user->name ?>" placeholder="">
                <?php if (isset($errors['name'])) : ?>
                <p class="text-danger"><?= $errors['name'] ?></p>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user->email ?>" placeholder="name@example.com">
                <?php if (isset($errors['email'])) : ?>
                <p class="text-danger"><?= $errors['email'] ?></p>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image" placeholder="">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>