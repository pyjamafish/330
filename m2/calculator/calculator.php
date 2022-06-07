<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My calculator</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
    <header>
        <h1>My calculator</h1>
    </header>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <p>
            <!-- Actions -->
            <label for="add">
                <input type="radio" name="action" id="add" value="add">
                Add
            </label>

            <label for="subtract">
                <input type="radio" name="action" id="subtract" value="subtract">
                Subtract
            </label>

            <label for="multiply">
                <input type="radio" name="action" id="multiply" value="multiply">
                Multiply
            </label>

            <label for="divide">
                <input type="radio" name="action" id="divide" value="divide">
                Divide
            </label>
        </p>

        <p>
            <!-- Input 1 -->
            <label for="input1">
                Input 1:
                <input type="number" name="input1" id="input1">
            </label>

        </p>

        <p>
            <!-- Input 2 -->
            <label for="input2">
                Input 2:
                <input type="number" name="input2" id="input2">
            </label>

        </p>

        <p>
            <input type="submit" value="Calculate">
        </p>
    </form>

    <?php
    function safe_divide($input1, $input2) {
        if ($input2 == 0) {
            return "Undefined";
        }

        return $input1 / $input2;
    }

    function calculate($action, $input1, $input2) {
        switch ($action):
            case "add":
                return $input1 + $input2;
            case "subtract":
                return $input1 - $input2;
            case "multiply":
                return $input1 * $input2;
            case "divide":
                return safe_divide($input1, $input2);
        endswitch;

        return "Action must be \"add\", \"subtract\", \"multiply\", or \"divide\"";
    }

    if (isset($_POST["action"]) and isset($_POST["input1"]) and isset($_POST["input2"])) {
        printf("Output: %s", calculate($_POST["action"], $_POST["input1"], $_POST["input2"]));
    }
    ?>
</body>
</html>
