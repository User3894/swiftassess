<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./login_signUp.css">
</head>
<body style="background-color: azure;">


<?php
session_start();

if (isset($_POST['signup'])) {
    header("Location: ./signUp.php");
    exit(0);
}

if (isset($_SESSION["sessionId"])) {
    $permissions = explode(",", $_SESSION["sessionId"])[1];
    if ($permissions == "user") {
        header("Location: ./index.php");
    } elseif ($permissions == "admin") {
        header("Location: ./manageQA.php");
    }
    exit(0);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($connection, $_POST['userName']);
    $password = mysqli_real_escape_string($connection, $_POST['userPassword']);
    $hashedPassword = md5($password); // Consider using stronger hashing algorithm

    $query = "SELECT * FROM `users` WHERE (userEmail='$username' OR userName='$username') AND userPassword='$hashedPassword'";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["sessionId"] = $row["userName"] . "," . $row['userPermission'];
        mysqli_close($connection);
        if ($row['userPermission'] == "user") {
            header("Location: ./index.php");
        } elseif ($row['userPermission'] == "admin") {
            header("Location: ./index.php");
        }
        exit(0);
    } else {
        echo "<script>alert('The username and password are incorrect');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/login_signUp.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="userName" placeholder="Enter your username or email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="userPassword" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
        <br>
        <form method="post">
            <button type="submit" name="signup">Sign Up</button>
        </form>
    </div>
</body>
</html>

