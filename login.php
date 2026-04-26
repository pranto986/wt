<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .error   { color: red;   font-size: 0.9em; }
        .success { color: green; font-weight: bold; }
        input  { margin: 8px 0; padding: 8px; width: 320px; }
        label  { font-weight: bold; }
    </style>
</head>
<body>

    <h2>Student Login - PHP Cookies</h2>

    <?php

    $username = $password = "";
    $usernameErr = $passwordErr = "";
    $success = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])) {
            $usernameErr = "Username is required";
        } else {
            $username = trim($_POST["username"]);
        }
        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = $_POST["password"];
        }
        if (empty($usernameErr) && empty($passwordErr)) {

            $cookieUser = $_COOKIE["reg_username"] ?? "";
            $cookiePass = $_COOKIE["reg_password"] ?? "";

            if ($username === $cookieUser && $password === $cookiePass) {
                $success = "Login Successful! Welcome, " . htmlspecialchars($username) . "!";
            } else {
                $usernameErr = "Invalid username or password.";
            }
        }
    }
    ?>

    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
        <p>You are now logged in. <a href="index.php">Go to Home</a></p>

        <?php
        echo "<p><strong>Cookie Info:</strong></p>";
        echo "<p>Logged in as: <b>" . htmlspecialchars($_COOKIE["reg_username"]) . "</b></p>";
        ?>

    <?php else: ?>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
        <span class="error">* <?php echo $usernameErr; ?></span><br><br>

        <label>Password:</label><br>
        <input type="password" name="password">
        <span class="error">* <?php echo $passwordErr; ?></span><br><br>

        <input type="submit" value="Login" style="padding: 12px 25px; font-size: 16px;">

    </form>

    <br><a href="registration.php" style="color:#3498db;">← Back to Register</a>

    <?php endif; ?>

</body>
</html>