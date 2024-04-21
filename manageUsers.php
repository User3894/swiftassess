<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Panel</title>
    <link rel="stylesheet" href="./manageQA_Users.css">
    <style>
        .logout-btn {
            float: right;
            padding: 14px 20px;
            color: white;
            border: none;
            font-family: Arial, Sans-serif;
            font-weight: bold;
            font-size: 16px;
            
        }

        .navbar , .logout-btn {
            background-color: blue;
            overflow: hidden;
        }

        span {
            text-decoration: underline;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 16px;
        }

        .navbar a:hover, .logout-btn:hover {
            background-color: black;
            color: white;
            
        }

        @media screen and (max-width: 600px) {
            .navbar a {
                float: none;
                display: block;
                text-align: left;
            }
        }
    </style>
</head>
<body style="background-color: azure;">


    <?php

        //start session.
        session_start();

        //check session
        if(!isset($_SESSION['sessionId'])) {
            // Session is not active
            header("Location:./login.php");
            exit(0);
        }

        // get user Permissions
        $userName = explode(",", $_SESSION['sessionId'])[0];

        # check permission
        if(str_getcsv($_SESSION['sessionId'], ",")[1] == "user") {
            # redirect
            header("Location: ./index.php");
            exit(0);
        }

        // session destroy
        if(isset($_POST["logout"])) {
            session_destroy();
            header("Location: ./login.php");
            exit(0);
        }

        // insert info
        if (isset($_POST["insert-data"])) {
            header("Location: ./insert.php");
            exit(0);
        }

    
        // Establish a connection to the database
        $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

        // Define the SQL query to select all users
        $query = "SELECT * FROM `users`";

        // Execute the SQL query
        $result = mysqli_query($connection, $query);

        // close connection
        mysqli_close($connection);

        // Handle delete action
        if (isset($_POST['delete'])) {

            // Establish a connection to the database
            $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");
            
            // get id from input field
            $id = $_POST['id'];

            // Execute the SQL query
            $result = mysqli_query($connection ,"DELETE FROM users WHERE userId = $id");

            // close connection
            mysqli_close($connection);

            // Redirect to the index page upon successful login
            header("Location: ".$_SERVER['PHP_SELF']);

            // Exit the script with a successful status
            exit(0);
        }

    ?>


<div class="navbar">
    <a href="./index.php">Home</a>
    <a href="./manageQA.php">Manage QA</a>
    <form method="post">
        <button type="submit" name="logout" class="logout-btn">Logout: <span> <?php echo $userName; ?> </span></button>
    </form>
</div>

    
<h1 style="color:black; font-family: Times New Roman; text-align: center;">Control Panel For Manage Users</h1>

<form method="post" style="padding-left:10%; display:inline;">
    <button type="submit" name="insert-data" class="form-btn">Insert</button>
</form>

<br><br>

<table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Password</th>
            <th>Permission</th>
            <th style="width:180px">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td> <?php echo $row["userId"]; ?> </td>
            <td> <?php echo $row["userName"]; ?> </td>
            <td> <?php echo $row["userEmail"]; ?> </td>
            <td> <?php echo $row["userPassword"]; ?> </td>
            <td> <?php echo $row["userPermission"]; ?> </td>

            <td>
                <form method="post" class="action-form" style="display: inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row["userId"]; ?>">
                    <button type="submit" name="delete" class="form-btn">Delete</button>
                </form>
                <form method="post" action="./update.php" class="action-form" style="display: inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row["userId"]; ?>">
                    <button type="submit" name="update" class="form-btn">Update</button>
                </form>

            </td>
        </tr>
        <?php endwhile; $result = null; ?>
    </tbody>
</table>

</body>
</html>