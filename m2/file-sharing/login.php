<?php
/**
 * The login page.
 */

require_once "constants.php";
session_start();

$error = null;

function login(string $username) {
    global $error;

    $usernames_file = sprintf("%s/usernames.txt", DATA_ROOT);
    $usernames_array = explode("\n", file_get_contents($usernames_file));

    if (in_array($username, $usernames_array)) {
        $_SESSION['username'] = $username;
        header("Location: files.php");
        exit();
    } else {
        $error = "Account not found";
    }
}

if (isset($_POST["username"])) {
    login($_POST["username"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>File Sharing</h1>

    <h2>Login</h2>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <p>
            <label for="username">Username: </label>
            <input type="text" name="username" id="username">
        </p>

        <p>
            <input type="submit" value="Log in">
        </p>
    </form>

    <p>
        <?php
        if (isset($error)) {
            print($error);
        }
        ?>
    </p>
</body>
</html>