<?php
/**
 * The main page for accessing files.
 * A user must first log in (using login.php) to see this page.
 */
require_once("constants.php");

session_start();
# https://stackoverflow.com/a/15088537
if(!isset($_SESSION['username'])){
    header("Location:login.php");
    exit;
}

function upload(): bool
{
    $upload_dest = sprintf(
        "%s/%s/%s",
        DATA_ROOT,
        $_SESSION['username'],
        basename($_FILES['uploaded-file']['name'])
    );

    # https://www.php.net/manual/en/features.file-upload.post-method.php
    return move_uploaded_file($_FILES['uploaded-file']['tmp_name'], $upload_dest);
}

function get_files_array(): array
{
    $user_dir = sprintf("%s/%s", DATA_ROOT, $_SESSION['username']);
    return scandir($user_dir);
}

function get_files_table(): string
{
    $table = "<table>";
    foreach (get_files_array() as $file) {
        $table .= "<tr>";
        $table .= "<td> $file </td>";
        $table .= "</tr>";
    }
    $table .= "</table>";
    return $table;
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
    <form enctype="multipart/form-data" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="8000000" /> <!-- 8MB -->
        <input name="uploaded-file" type="file" />
        <input type="submit" value="Upload" />
    </form>

    <p>
        <?php
        if (isset($_FILES['uploaded-file'])) {
            if (upload()) {
                printf("%s successfully uploaded.", $_FILES['uploaded-file']['name']);
            } else {
                printf("An error occurred. %s not uploaded.", $_FILES['uploaded-file']['name']);
            }
        }
        ?>
    </p>

    <h2>Download</h2>
    <?php
        print(get_files_table())
    ?>
</body>
</html>
