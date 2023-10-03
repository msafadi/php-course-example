<?php
session_start();

include __DIR__ . '/../includes/functions.php';

if (!isset($_SESSION['auth'])) {
    redirect('../login.php');
}

?>

<?php include __DIR__ . '/../template/header.php' ?>

        <h1 class="mb-5">List Users</h1>

        <?php if (isset($_GET['success'])) : ?>
        <div class="alert alert-success">
            <?= $_GET['success'] ?>
        </div>
        <?php endif ?>

        <div class="mb-3">
            <a href="create.php" class="btn btn sm btn-primary">Create User</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                include __DIR__ . '/../includes/connection.php';
                $sql = 'SELECT * FROM users ORDER BY created_at DESC';
                $stmt = $db->prepare($sql);
                $stmt->execute();
                while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) :
                ?>
                <tr>
                    <td><img src="../uploads/<?= $row->profile_image ?>" height="60" title="Profile Image"></td>
                    <td><?= $row->id ?></td>
                    <td><?= $row->name ?></td>
                    <td><?= $row->email ?></td>
                    <td><?= $row->created_at ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row->id ?>" class="btn btn-sm btn-dark">Edit</a>
                        <a href="delete.php?id=<?= $row->id ?>" class="btn btn-sm btn-danger">Delete</a>
                        
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>

        <?php include __DIR__ . '/../template/footer.php' ?>