<?php
session_start();
# https://stackoverflow.com/a/15088537
if(!isset($_SESSION['username'])){
    header("Location:login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files</title>
</head>
<body>
    <h1>File Sharing</h1>
    <p>
        <?php
        printf("Logged in as %s", $_SESSION['username'])
        ?>
    </p>
    <p>
        <a href="logout.php">(Logout)</a>
    </p>

    <h2>Upload</h2>
    <h2>Files</h2>
</body>
</html>
