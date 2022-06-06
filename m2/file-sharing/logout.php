<?php
/**
 * This file handles logging out.
 * It's called when a user clicks the logout button in files.php.
 */

session_start();
session_destroy();
header("Location: login.php");
exit();
