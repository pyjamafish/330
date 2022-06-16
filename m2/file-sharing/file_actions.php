<?php
/**
 * This file handles actions on a file.
 * The user's username is given by the session variable,
 * the file is given by the GET variable,
 * and the action is given by the GET variable.
 */

require_once("constants.php");

function view_file($full_path) {
    // https://classes.engineering.wustl.edu/cse330/index.php?title=PHP#Sending_a_File_to_the_Browser
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($full_path);

    header("Content-Type: ".$mime);
    header('content-disposition: inline; filename="'.basename($full_path).'";');
    readfile($full_path);
}

function delete_file($full_path) {
    unlink($full_path);
    header("Location:main.php");
}

session_start();
# https://stackoverflow.com/a/15088537
if (!isset($_SESSION['username'])) {
    header("Location:sign_in.php");
    exit;
}

# If no file provided, go to main page
if (!isset($_GET['file'])) {
    header("Location:main.php");
    exit;
}

$filename = $_GET['file'];
// filenames are already validated on upload,
// so no validation needed here

$username = $_SESSION['username'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
    echo "Your username appears to be invalid. Please contact the webmaster for help.";
    exit;
}

$full_path = sprintf(
    "%s/%s/%s",
    DATA_ROOT,
    $_SESSION['username'],
    $filename
);

if ($_GET['action'] == "view") {
    view_file($full_path);
} else if ($_GET['action'] == "delete") {
    delete_file($full_path);
}