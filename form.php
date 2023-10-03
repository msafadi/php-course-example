<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Form</title>
</head>
<body>
    <form action="form.php?page=1&ref=php-course&name=PHP" method="post">
        <div>
            <label for="">Name</label>
            <input type="text" name="user name">
        </div>
        <div>
            <label for="">Email</label>
            <input type="email" name="user.email">
        </div>
        <div>
            <label for="">Country</label>
            <select name="country" id="">
                <option value=""></option>
                <option value="ps">Palestine</option>
                <option value="jo">Jordan</option>
                <option value="eg">Egypt</option>
                <option value="sa">Saudi Arabia</option>
            </select>
        </div>
        <div>
            <label for="">Skills</label>
            <div>
                <input type="checkbox" name="skill[]" value="php"> PHP
            </div>
            <div>
                <input type="checkbox" name="skill[]" value="html"> HTML
            </div>
            <div>
                <input type="checkbox" name="skill[]" value="js"> JavaScript
            </div>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    <pre>
        <?php
            var_dump($_GET, $_POST, $_REQUEST);
            echo 'Name: ' . $_POST['user_name'] . "\n";
            echo 'Email: ' . $_POST['user_email'] . "\n";
            echo 'Country: ' . $_POST['country'] . "\n";
            echo 'Skill: ' . implode(', ', $_POST['skill']) . "\n";
            echo 'Ref: ' . $_GET['ref'] . "\n";
            echo 'Page: ' . $_GET['page'] . "\n";
        ?>
    </pre>
</body>
</html>








