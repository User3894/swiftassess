<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert</title>
    <link rel="stylesheet" href="./login_signUp.css">
</head>
<body style="background-color: azure;">

    <?php

        // create session
        session_start();

        // check session
        $userPerm = isset($_SESSION['sessionId'])? explode(",", $_SESSION["sessionId"])[1] : NULL;

        //cheack user permission
        if($userPerm != "admin") {
            //redirect
            header("Location: ./login.php");
            exit(0);
        }

        if (isset($_POST['back'])) {
            header("Location: ./manageUsers.php");
            exit(0);
        }

        // store userInput
        $userName;
        $userPassword;
        $userEmail;
        $userPermission;

        // store query
        $query;

        // Establish a connection to the database
        $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

        // Define the SQL query to insert to users table
        //$query = "INSERT INTO `users`(`userName`, `userPassword`, `userEmail`, `userPhone`, `userPerm`, `userDept`) VALUES ('$userName','$userPassword','$userEmail','$userPhone','$userPermission','$userDepart')";

        // Check if the 'insert' form has been submitted
        if(isset($_POST['insert'])) {


            // get and check information from POST method is Empty or no
            $userName = $_POST["userName"]? $_POST["userName"]: NULL;
            $userPassword = $_POST["userPassword"]? md5($_POST["userPassword"]): NULL;
            $userEmail = $_POST["userEmail"]? $_POST["userEmail"]: NULL;
            $userPermission = $_POST["userPermission"]? $_POST["userPermission"]: NULL;

            // check the inputUser is NULL or not
            if (isset($userName) && isset($userPassword) && isset($userEmail) && isset($userPermission)) {
                
                // Define the SQL query to insert to users table
                $query = "INSERT INTO `users`(`userName`, `userEmail`, `userPassword`, `userPermission`) VALUES ('$userName','$userEmail','$userPassword','$userPermission')";

                // Execute the SQL query
                $result = mysqli_query($connection, $query);

                // close connection to the database
                mysqli_close($connection);

                // clear variable
                $userName = NULL;
                $userPassword = NULL;
                $userEmail = NULL;
                $userPermission = NULL;

                // Output success message
                echo "<script>alert('Enter successful');</script>";
            } else {
                
                echo "<script>alert('Wrong entry');</script>";
            }

            
        }
    ?>
    <div class="login-container">
        
        <h2>Insert Information</h2>

        <form method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="userName" placeholder="Enter your username" >
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="userPassword" placeholder="Enter your Password" >
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="userEmail" placeholder="Enter your Email" >
            </div>
            <div class="input-group">
                <label for="user-type">Select User Type:</label>
                <select id="user-type" name="userPermission" style="width: calc(102% - 1px); padding: 12px; border-radius: 6px; border: 1px solid #ccc; background-color:white;">
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                </select>
            </div>
            <button type="submit" name="insert">Insert</button>
        </form>
        <br>

        <form method="post">
        <button type="submit" name="back">Back</button>
        </form>
    </div>

</body>
</html>
