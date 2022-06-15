<?php
/**
 * This file handles uploading files to the server.
 */
require_once "constants.php";

session_start();
# https://stackoverflow.com/a/15088537
if(!isset($_SESSION['username'])){
    header("Location:login.php");
    exit;
}

$upload_dest = sprintf(
    "%s/%s/%s",
    DATA_ROOT,
    $_SESSION['username'],
    basename($_FILES['uploaded-file']['name'])
);

# https://www.php.net/manual/en/features.file-upload.post-method.php
if (move_uploaded_file($_FILES['uploaded-file']['tmp_name'], $upload_dest)) {
    echo "File successfully uploaded.\n";
} else {
    echo "An error occurred. File not uploaded.\n";
}
