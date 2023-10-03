<?php
    session_start();

    include __DIR__ . '/../includes/functions.php';

    if (!isset($_SESSION['auth'])) {
        redirect('../login.php');
    }
    
    require_once __DIR__ . '/../includes/connection.php';

    $errors = [];

    if ( strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ) {
        $errors = validate_user($_POST);

        if (!$errors) {

            $filepath = basename( upload('profile_image') );

            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $sql = 'INSERT INTO users (name, email, password, profile_image, created_at) 
                    VALUES (:name, :email, :password, :file, :time)';

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':file', $filepath);
            $stmt->bindParam(':time', date('Y-m-d H:i:s'));
            $stmt->execute();

            // PRG
            redirect('index.php?success=User+Created');
        }
    }
?>
<?php include __DIR__ . '/../template/header.php' ?>

<h1>Create User</h1>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="">
                <?php if (isset($errors['name'])) : ?>
                <p class="text-danger"><?= $errors['name'] ?></p>
                <?php endif ?>
            </div>
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
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image" placeholder="">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <?php include __DIR__ . '/../template/footer.php' ?>