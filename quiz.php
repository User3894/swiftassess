<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Interface</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: azure;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #b9f5ae;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .question {
            margin-bottom: 20px;
        }
        .answers {
            list-style-type: none;
            padding-bottom: 20px;
        }
        .answers li {
            margin-bottom: 10px;
        }

        .styled-button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
            transition-duration: 0.4s;
        }

        /* On hover, change the background color */
        .styled-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php

//start session.
session_start();

//check session
if(!isset($_SESSION['sessionId'])) {
    // Session is not active
    header("Location:./login.php");
    exit(0);
}


// Establish a connection to the database
$connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

// // Check if the form is submitted
// if(isset($_POST['submit'])) {
//     // Define the SQL query to select all questions and answers
//     $query = "SELECT * FROM qa";

//     // Execute the SQL query
//     $result = mysqli_query($connection, $query);

//     // Initialize scores
//     $scores = 0;

//     // Loop through each submitted answer
//     for ($c = 1; isset($_POST["answer".$c]); $c++) {
//         // Fetch the corresponding row from the result set
//         $row = mysqli_fetch_assoc($result);
        
//         // Check if the submitted answer is correct
//         if ($_POST["answer".$c] == $row['correct_answer']) {
//             $scores += 1;
//         }
//     }

//     // Output the scores
//     echo "<script>alert('$scores')</script>";
// }

// Define the SQL query to select all questions and answers
$query = "SELECT * FROM qa";

// Execute the SQL query
$result = mysqli_query($connection, $query);
?>

<div class="container">
    <h2>Test Question</h2>
    <form method="post" action="./index.php">

        <?php $count = 1; while($row = mysqli_fetch_assoc($result)): ?>

        <div class="question">
            <p><?php echo "$count) ". $row['question'];?></p>
        </div>
        <div class="answers">
            <label><input type="radio" name="answer<?php echo $count;?>" value="<?php echo $row['answer_1'];?>"> A) <?php echo $row['answer_1'];?></label><br>
            <label><input type="radio" name="answer<?php echo $count;?>" value="<?php echo $row['answer_2'];?>"> B) <?php echo $row['answer_2'];?></label><br>
            <label><input type="radio" name="answer<?php echo $count;?>" value="<?php echo $row['answer_3'];?>"> C) <?php echo $row['answer_3'];?></label><br>
            <label><input type="radio" name="answer<?php echo $count;?>" value="<?php echo $row['answer_4'];?>"> D) <?php echo $row['answer_4'];?></label><br>
        </div>
        <hr>
        <?php $count+=1; endwhile; ?>

        <button type="submit" name="submit" class="styled-button">Submit</button>
    </form>
</div>

<?php
// Close connection
mysqli_close($connection);
?>

</body>
</html>
