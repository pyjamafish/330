<?php
session_start();
# https://stackoverflow.com/a/15088537
if(!isset($_SESSION['username'])){
    header("Location:login.php");
    exit;
}

