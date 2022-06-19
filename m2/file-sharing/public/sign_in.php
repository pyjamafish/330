<?php
/**
 * The sign-in page.
 */

require_once "constants.php";
session_start();

$error = null;

function sign_in(string $username): void
{
    global $error;

    $usernames_file = sprintf("%s/users.txt", DATA_ROOT);
    $usernames_array = file($usernames_file, FILE_IGNORE_NEW_LINES);

    if (in_array($username, $usernames_array)) {
        $_SESSION['username'] = $username;
        header("Location: main.php");
        exit();
    } else {
        $error = "Account not found";
    }
}

if (isset($_POST["username"])) {
    sign_in($_POST["username"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel=stylesheet href="../assets/css/main.css">
</head>
<body>
    <header>
        <h1>File Sharing</h1>
    </header>

    <h2>Sign in</h2>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <p>
            <label for="username">Username: </label>
            <input type="text" name="username" id="username">
        </p>

        <p>
            <input type="submit" value="Submit">
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