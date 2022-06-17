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
    $filename = basename($_FILES['uploaded-file']['name']);
    # Exit early if the file has an invalid name.
    # Regex modified from the 330 wiki to allow spaces.
    if (!preg_match('/^[\w_.\- ]+$/', $filename)) {
        return false;
    }

    $upload_dest = sprintf(
        "%s/%s/%s",
        DATA_ROOT,
        $_SESSION['username'],
        $filename
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
                <td><a href="file_actions.php?file=$file&action=view">View</a></td>
                <td><a href="file_actions.php?file=$file&action=delete">Delete</a></td>
            </tr>
        EOD;
    }
    $table .= "</table>";
    return $table;
}

function get_disk_usage_mb($username): float
{
    $user_dir = DATA_ROOT . "/" . $username;

    $bytes_total = 0;
    foreach(scandir($user_dir) as $file){
        $bytes_total += filesize($user_dir . "/" . $file);
    }

    return $bytes_total / 1048576;
}

function get_disk_usage_string($username): string
{
    $disk_usage_mb = get_disk_usage_mb($username);
    return sprintf("%.2f MB / 128 MB", $disk_usage_mb);
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
        printf("Signed in as %s", htmlspecialchars($_SESSION['username']));
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
            $escaped_filename = htmlspecialchars($_FILES['uploaded-file']['name']);
            if (upload()) {
                printf("%s successfully uploaded.", $escaped_filename);
            } else {
                printf("Invalid file or filename. %s not uploaded.", $escaped_filename);
            }
        }
        ?>
    </p>

    <h2>My files</h2>
    <?php
    print(get_files_table())
    ?>

    <h2>Disk usage</h2>
    <?php
    print(get_disk_usage_string($_SESSION['username']))
    ?>
</body>
</html>
