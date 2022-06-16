<?php
/**
 * The main page for accessing files.
 * A user must first sign in (using sign_in.php) to see this page.
 */
require_once("constants.php");

session_start();
# https://stackoverflow.com/a/15088537
if (!isset($_SESSION['username'])) {
    header("Location:sign_in.php");
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


/**
 * Returns true if the given file should be displayed.
 * The "." and ".." files should not be displayed.
 * This function is used as the filter in get_files_array.
 * @param $file
 * @return bool
 */
function is_displayed_file($file): bool
{
    return $file != "." && $file != "..";
}

function get_files_array(): array
{
    $user_dir = sprintf("%s/%s", DATA_ROOT, $_SESSION['username']);
    $ls = scandir($user_dir);
    return array_filter($ls, "is_displayed_file");
}

function get_files_table(): string
{
    $table = "<table>";
    foreach (get_files_array() as $file) {
        $table .= <<<EOD
            <tr>
                <td> $file </td>
                <td><a href="./actions/open.php?file=$file">Open</a></td>
                <td><a href="./actions/delete.php?file=$file">Delete</a></td>
            </tr>
        EOD;
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
    <header>
        <h1>File Sharing</h1>
    </header>

    <p>
        <?php
        printf("Signed in as %s", $_SESSION['username'])
        ?>
        <a href="sign_out.php">(sign out)</a>
    </p>

    <h2>Upload a file</h2>
    <!-- https://www.php.net/manual/en/features.file-upload.post-method.php -->
    <form enctype="multipart/form-data" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="8000000"/> <!-- 8MB -->
        <input name="uploaded-file" type="file"/>
        <input type="submit" value="Upload"/>
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

    <h2>My files</h2>
    <?php
    print(get_files_table())
    ?>

    <h2>Download all files</h2>
</body>
</html>
