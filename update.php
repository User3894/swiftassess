<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel="stylesheet" href="./login_signUp.css">
</head>
<body>

    <?php

        // create session
        session_start();

        // check session
        if(!isset($_SESSION["sessionId"])) {
            // redirect
            header("Location: ./login.php");
            exit(0);
        }

        if (isset($_POST['back'])) {
            header("Location: ./manageUsers.php");
            exit(0);
        }

        // Prevent direct access to the update
        // if((isset($_POST["id"]) == "" && isset($_POST["id"]) == null) && (isset($_POST["userId"]) == "" && isset($_POST["userId"]) == null)) {
        //     header("Location: ./login.php");
        //     exit(0);
        // }

        // 1- T T = T
        // 2- F T = F
        // 3- T F = F
        // Prevent direct access to the update
        if(!isset($_POST["id"]) && !isset($_POST['userId'])) {
            header("Location: ./index.php");
            exit(0);
        }


        // store user data
        $userId = isset($_POST["id"])? $_POST["id"] : $_POST["userId"];
        $userName;
        $userPassword;
        $userEmail;
        $userPermission;

        // store query
        $query = "SELECT * FROM users WHERE userId = $userId";

        // Establish a connection to the database
        $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

        // get information from database
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));

        // close connection
        mysqli_close($connection);

    ?>
    <div class="login-container">
        <h2>Update User Information</h2>
        <form method="post">
            <div class="input-group">
                <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>" >
            </div>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="userName" placeholder="Enter your username" value="<?php echo $result["userName"]; ?>" >
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="userPassword" placeholder="Enter your Password" >
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="userEmail" placeholder="Enter your Email" value="<?php echo $result["userEmail"]; ?>">
            </div>
            <div class="input-group">
                <label for="user-type">Select User Type:</label>
                <select id="user-type" name="userPermission" style="width: calc(102% - 1px); padding: 12px; border-radius: 6px; border: 1px solid #ccc; background-color:white;">
                    <?php
                    
                        if($result["userPermission"] == "admin") {
                            echo "<option value=\"user\">user</option>";
                            echo "<option value=\"admin\" selected>admin</option>";
                        } else {
                            echo "<option value=\"user\" selected>user</option>";
                            echo "<option value=\"admin\">admin</option>";
                        }
                    
                    ?>
                </select>
            </div>
            <button type="submit" name="submit">update</button>
        </form>
        <br>
        <form method="post">
            <button type="submit" name="back">Back</button>
        </form>


        <?php

            // Check if the 'update' form has been submitted
            if(isset($_POST['submit'])) {

                // Establish a connection to the database
                $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

                // get userInput
                $userId = isset($_POST["userId"])?  $_POST["userId"]: NULL;
                $userName = isset($_POST["userName"])? $_POST["userName"] : NULL;
                $userPassword = isset($_POST["userPassword"])? $_POST["userPassword"] : NULL;
                $userEmail = isset($_POST["userEmail"])? $_POST["userEmail"] : NULL;
                $userPermission = isset($_POST["userPermission"])? $_POST["userPermission"] : NULL;


                // check the inputUser is NULL or not
                if ($userName != "" && $userEmail != "" && $userPassword != "") {

                    $userPassword = md5($userPassword);
                    
                    // Define the SQL query to insert to users table
                    $query = "UPDATE `users` SET `userName`='$userName', `userEmail`='$userEmail', `userPassword`='$userPassword', `userPermission`='$userPermission' WHERE `userId`=$userId";

                    // Execute the SQL query
                    $result = mysqli_query($connection, $query);

                    // close connection to the database
                    mysqli_close($connection);

                    // // Redirect to the index page upon successful login
                    header("Location: ./manageUsers.php");

                    // Exit the script with a successful status
                    exit(0);
                    
                } else {
                    
                    echo "<script>alert('Wrong Update');</script>";
                }

                
            }
        
        ?>

    </div>

</body>
</html>
