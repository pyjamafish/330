<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>My calculator</h1>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <p>
            <!-- Actions -->
            <input type="radio" name="action" id="add" value="add">
            <label for="add">Add</label>

            <input type="radio" name="action" id="subtract" value="subtract">
            <label for="subtract">Subtract</label>

            <input type="radio" name="action" id="multiply" value="multiply">
            <label for="multiply">Multiply</label>

            <input type="radio" name="action" id="divide" value="divide">
            <label for="divide">Divide</label>
        </p>

        <p>
            <!-- Input 1 -->
            <label for="input1">Input 1</label>
            <input type="number" name="input1" id="input1">
        </p>

        <p>
            <!-- Input 2 -->
            <label for="input2">Input 2</label>
            <input type="number" name="input2" id="input2">
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
        print(calculate($_POST["action"], $_POST["input1"], $_POST["input2"]));
    }
    ?>
</body>
</html>

<?php

