<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Registration</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .error { color: red; font-size: 0.9em; }
        .success { color: green; font-weight: bold; }
        input, select { margin: 8px 0; padding: 8px; width: 320px; }
        label { font-weight: bold; }
        table { margin-top: 15px; border-collapse: collapse; }
        td { padding: 8px 15px; border: 1px solid #ccc; }
        td:first-child { font-weight: bold; background: #f5f5f5; }
    </style>
</head>
<body>

    <h2>Registration Form - PHP Validation</h2>

    <?php

    $fullname = $email = $username = $password = $confirm = $age = $gender = $course = "";
    $fullnameErr = $emailErr = $usernameErr = $passwordErr = $confirmErr = $ageErr = $genderErr = $courseErr = $termsErr = "";
    $success = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["fullname"])) {
            $fullnameErr = "Full Name is required";
        } else {
            $fullname = test_input($_POST["fullname"]);
            if (!preg_match("/^[a-zA-Z ]+$/", $fullname)) {
                $fullnameErr = "Only letters and spaces allowed";
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST["username"])) {
            $usernameErr = "Username is required";
        } else {
            $username = test_input($_POST["username"]);
            if (strlen($username) < 5) {
                $usernameErr = "Username must be at least 5 characters";
            }
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = $_POST["password"];
            if (strlen($password) < 6) {
                $passwordErr = "Password must be at least 6 characters";
            }
        }

        if (empty($_POST["confirm"])) {
            $confirmErr = "Please confirm your password";
        } else {
            $confirm = $_POST["confirm"];
            if ($confirm !== $password) {
                $confirmErr = "Passwords do not match";
            }
        }

        if (empty($_POST["age"])) {
            $ageErr = "Age is required";
        } else {
            $age = test_input($_POST["age"]);
            if ($age < 18) {
                $ageErr = "Age must be 18 or above";
            }
        }

        if (empty($_POST["gender"])) {
            $genderErr = "Please select a gender";
        } else {
            $gender = $_POST["gender"];
        }
        if (empty($_POST["course"])) {
            $courseErr = "Please select a course";
        } else {
            $course = $_POST["course"];
        }
        if (!isset($_POST["terms"])) {
            $termsErr = "You must accept the Terms & Conditions";
        }
        if (empty($fullnameErr) && empty($emailErr) && empty($usernameErr) && empty($passwordErr) &&
            empty($confirmErr) && empty($ageErr) && empty($genderErr) && empty($courseErr) && empty($termsErr)) {

            setcookie("reg_username", $username, time() + 3600);
            setcookie("reg_password", $password, time() + 3600);

            $success = "Registration Successful!";
        }
    }

    function test_input($data) {
        $data = trim($data);
        return $data;
    }
    ?>

    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
        <table>
            <tr><td>Full Name</td><td><?php echo htmlspecialchars($fullname); ?></td></tr>
            <tr><td>Email</td><td><?php echo htmlspecialchars($email); ?></td></tr>
            <tr><td>Username</td><td><?php echo htmlspecialchars($username); ?></td></tr>
            <tr><td>Age</td><td><?php echo htmlspecialchars($age); ?></td></tr>
            <tr><td>Gender</td><td><?php echo htmlspecialchars($gender); ?></td></tr>
            <tr><td>Course</td><td><?php echo htmlspecialchars($course); ?></td></tr>
            <tr><td>Terms Agreed</td><td>Yes</td></tr>
        </table>
        <br><a href="login.php" style="color:#3498db;">Proceed to Login →</a>
    <?php else: ?>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

        <label>Full Name:</label><br>
        <input type="text" name="fullname" value="<?php echo $fullname; ?>">
        <span class="error">* <?php echo $fullnameErr; ?></span><br><br>

        <label>Email Address:</label><br>
        <input type="email" name="email" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo $username; ?>">
        <span class="error">* <?php echo $usernameErr; ?></span><br><br>

        <label>Password:</label><br>
        <input type="password" name="password">
        <span class="error">* <?php echo $passwordErr; ?></span><br><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="confirm">
        <span class="error">* <?php echo $confirmErr; ?></span><br><br>

        <label>Age:</label><br>
        <input type="number" name="age" value="<?php echo $age; ?>" min="1">
        <span class="error">* <?php echo $ageErr; ?></span><br><br>

        <label>Gender:</label><br>
        <input type="radio" name="gender" value="Male" <?php if($gender=="Male") echo "checked"; ?>> Male &nbsp;
        <input type="radio" name="gender" value="Female" <?php if($gender=="Female") echo "checked"; ?>> Female
        <span class="error">* <?php echo $genderErr; ?></span><br><br>

        <label>Course Selection:</label><br>
        <select name="course" style="width:338px;">
            <option value="">-- Select Course --</option>
            <option value="Computer Science"   <?php if($course=="Computer Science") echo "selected"; ?>>Computer Science</option>
            <option value="Engineering"        <?php if($course=="Engineering") echo "selected"; ?>>Engineering</option>
            <option value="Business Administration" <?php if($course=="Business Administration") echo "selected"; ?>>Business Administration</option>
            <option value="Medicine"           <?php if($course=="Medicine") echo "selected"; ?>>Medicine</option>
            <option value="Law"                <?php if($course=="Law") echo "selected"; ?>>Law</option>
        </select>
        <span class="error">* <?php echo $courseErr; ?></span><br><br>

        <input type="checkbox" name="terms" style="width:auto;">
        <label style="font-weight:normal;"> I agree to the Terms & Conditions</label>
        <span class="error">* <?php echo $termsErr; ?></span><br><br>

        <input type="submit" value="Register" style="padding: 12px 25px; font-size: 16px;">

    </form>
    <?php endif; ?>

</body>
</html>