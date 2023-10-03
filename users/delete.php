<?php
    session_start();

    include __DIR__ . '/../includes/functions.php';

    if (!isset($_SESSION['auth'])) {
        redirect('../login.php');
    }
    
    require_once __DIR__ . '/../includes/connection.php';

    if (isset($_POST['user_id'])) {
        $sql = 'DELETE FROM users WHERE id = :id';
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':id' => $_POST['user_id']
        ]);

        header('Location: index.php?success=User+Deleted');
        exit;
    }

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="mb-5">Delete User</h1>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="user_id" value="<?= $_GET['id'] ?>">
            <p>Are you sure you want to delete this user?</p>
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="index.php" class="btn btn-dark">Cancel</a>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>