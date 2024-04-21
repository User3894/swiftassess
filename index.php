<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Homepage</title>
  <link rel="stylesheet" href="./userIndex.css">
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

        span {
            text-decoration: underline;
        }

        .navbar , .logout-btn {
            background-color: blue;
            overflow: hidden;
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

        // session destroy
        if(isset($_POST["logout"])) {
            session_destroy();
            header("Location: ./login.php");
            exit(0);
        }


        // get permissions
        $userPermission = explode(",", $_SESSION['sessionId'])[1];
        $userName = explode(",", $_SESSION['sessionId'])[0];

        if($userPermission == "admin") {
            echo "<div class=\"navbar\">";
                echo "<a href=\"./index.php\">Home</a>";
                echo "<a href=\"./manageUsers.php\">Manage User</a>";
                echo "<a href=\"./manageQA.php\">Manage QA</a>";
                echo "<a href=\"./aboutAs.php\">About as</a>";
                echo "<form method=\"post\">";
                    echo "<button type=\"submit\" name=\"logout\" class=\"logout-btn\">Logout: <span>$userName</span></button>";
                echo "</form>";
            echo "</div>";
        } else {
            echo "<div class=\"navbar\">";
                echo "<a href=\"./index.php\">Home</a>";
                echo "<a href=\"./aboutAs.php\">About as</a>";
                echo "<form method=\"post\">";
                    echo "<button type=\"submit\" name=\"logout\" class=\"logout-btn\">Logout: <span>$userName</span></button>";
                echo "</form>";
            echo "</div>";
        }

        // Establish a connection to the database
        $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

        // Define the SQL query to select all questions and answers
        $query = "SELECT * FROM qa";

        // Number of questions
        $num_Q = 0;

        // Execute the SQL query
        $result = mysqli_query($connection, $query);
        $num_Q = mysqli_num_rows($result);

        // close connection database
        mysqli_close($connection);


        // Initialize scores
        $scores = 0;

        // Check if the form is submitted
        if(isset($_POST['submit'])) {

            // Establish a connection to the database
            $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

            // Execute the SQL query
            $result = mysqli_query($connection, $query);

            // Loop through each submitted answer
            for ($c = 1; isset($_POST["answer".$c]); $c++) {
                // Fetch the corresponding row from the result set
                $row = mysqli_fetch_assoc($result);
                
                // Check if the submitted answer is correct
                if ($_POST["answer".$c] == $row['correct_answer']) {
                    $scores += 1;
                }
            }

            // close connection database
            mysqli_close($connection);
        }
    ?>



  <div class="container">
    <h1>programming, networks, and cybersecurity</h1>
    <div class="instructions">
      <h2>Welcome!</h2>
    </div>
    <div class="quiz-details">
      <p>Number of Questions: <?php echo $num_Q;?></p>
      <p>The lowest degree of success: <?php echo ceil($num_Q/2);?></p>
      <br>
      <p>Scoring: <?php echo $scores;?></p>
        <?php 

            if($scores==$num_Q) { 
                echo "<p>You have successfully answered all questions <h1>🏆</h1></p>";
            } else {
                if(isset($_POST['submit']) && ($scores < 4)) {
                    echo "<p>You failed some questions <h1>😴</h1></p>";
                }
            }

        ?>
    </div>
    <a href="./quiz.php" class="begin-quiz-btn">Begin Quiz</a>
  </div>
</body>
</html>
