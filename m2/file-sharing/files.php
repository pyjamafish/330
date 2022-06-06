<?php
/**
 * The main page for accessing files.
 * A user must first log in (using login.php) to see this page.
 */

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
        <a href="logout.php">(log out)</a>
    </p>

    <h2>Upload</h2>
    <!-- https://www.php.net/manual/en/features.file-upload.post-method.php -->
    <form enctype="multipart/form-data" action="upload.php" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="8000000" /> <!-- 8MB -->
        <input name="uploaded-file" type="file" />
        <input type="submit" value="Upload" />
    </form>

    <h2>Download</h2>
</body>
</html>
