<?php
require_once("constants.php");

session_start();
# https://stackoverflow.com/a/15088537
if (!isset($_SESSION['username'])) {
    header("Location:sign_in.php");
    exit;
}

$filename = sys_get_temp_dir() . "/file_sharing_archive.zip";

$zip = new ZipArchive();
$zip->open($filename, ZipArchive::CREATE);

$files_array = scandir(DATA_ROOT . "/" . $_SESSION['username']);
foreach ($files_array as $file) {
    $zip->addFile($file);
}
$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$filename);
header('Content-Length: ' . filesize($filename));
readfile($filename);

unlink($filename);
header("Location:main.php");