<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update QA</title>
    <link rel="stylesheet" href="./login_signUp.css">
</head>
<body style="background-color: azure;">

    <?php

        // create session
        session_start();

        // check session and get user permissions
        $userPerm = isset($_SESSION['sessionId'])? explode(",", $_SESSION["sessionId"])[1] : NULL;

        //cheack user permission
        if($userPerm != "admin") {
            //redirect
            header("Location: ./login.php");
            exit(0);
        }

        if (isset($_POST['back'])) {
            header("Location: ./manageQA.php");
            exit(0);
        }

        // 1- T T = T
        // 2- F T = F
        // 3- T F = F
        // Prevent direct access to the update
        if(!isset($_POST["id"]) && !isset($_POST['QA_Id'])) {
            header("Location: ./index.php");
            exit(0);
        }



        // store userInput
        $QA_Id = isset($_POST['id'])? $_POST['id'] : $_POST['QA_Id'];
        $question;
        $answer_1;
        $answer_2;
        $answer_3;
        $answer_4;
        $correct_answer;
        $level;

        // Establish a connection to the database
        $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

        // store query
        $query = "SELECT * FROM qa WHERE QA_Id=$QA_Id";
        
        // get information from database
        $result = mysqli_fetch_assoc(mysqli_query($connection, $query));

        // close connection
        mysqli_close($connection);
    ?>


    <div class="login-container" style="width:600px; padding-top: 300px">
        
        <h2>Update QA</h2>

        <form method="post">
            <div class="input-group">
                <input type="hidden" id="QA_Id" name="QA_Id" placeholder="Enter your question" style="height:50px" value="<?php echo $QA_Id; ?>">
            </div>
            <div class="input-group">
                <label for="question">question</label>
                <input type="text" id="question" name="question" placeholder="Enter your question" style="height:50px" value="<?php echo $result['question']; ?>">
            </div>
            <div class="input-group">
                <label for="answer_1">answer_1</label>
                <input type="text" id="answer_1" name="answer_1" placeholder="Enter your answer_1" style="height:50px" value="<?php echo $result['answer_1']; ?>">
            </div>
            <div class="input-group">
                <label for="answer_2">answer_2</label>
                <input type="text" id="answer_2" name="answer_2" placeholder="Enter your answer_2" style="height:50px" value="<?php echo $result['answer_2']; ?>">
            </div>
            <div class="input-group">
                <label for="answer_3">answer_3</label>
                <input type="text" id="answer_3" name="answer_3" placeholder="Enter your answer_3" style="height:50px" value="<?php echo $result['answer_3']; ?>">
            </div>
            <div class="input-group">
                <label for="answer_4">answer_4</label>
                <input type="text" id="answer_4" name="answer_4" placeholder="Enter your answer_4" style="height:50px" value="<?php echo $result['answer_4']; ?>">
            </div>
            <div class="input-group">
                <label for="level">Select correct_answer:</label>
                <input type="text" id="correct_answer" name="correct_answer" placeholder="Enter your correct_answer" style="height:50px" value="<?php echo $result['correct_answer']; ?>">

                <!-- <select id="correct_answer" name="correct_answer" style="width: calc(102% - 1px); padding: 12px; border-radius: 6px; border: 1px solid #ccc; background-color:white;">
                    <?php
                    
                        // if ($result['correct_answer'] == 1) {
                        //     # code...
                        //     echo "<option value=\"1\" selected>1</option>";
                        //     echo "<option value=\"2\">2</option>";
                        //     echo "<option value=\"3\">3</option>";
                        //     echo "<option value=\"4\">4</option>";
                        // } elseif ($result['correct_answer'] == 2) {
                        //     # code...
                        //     echo "<option value=\"1\">1</option>";
                        //     echo "<option value=\"2\" selected>2</option>";
                        //     echo "<option value=\"3\">3</option>";
                        //     echo "<option value=\"4\">4</option>";
                        // } elseif ($result['correct_answer'] == 3) {
                        //     # code...
                        //     echo "<option value=\"1\">1</option>";
                        //     echo "<option value=\"2\">2</option>";
                        //     echo "<option value=\"3\" selected>3</option>";
                        //     echo "<option value=\"4\">4</option>";
                        // } else {
                        //     # code...
                        //     echo "<option value=\"1\">1</option>";
                        //     echo "<option value=\"2\">2</option>";
                        //     echo "<option value=\"3\">3</option>";
                        //     echo "<option value=\"4\" selected>4</option>";
                        // }
                    
                    ?>
                </select> -->
            </div>
            <br>
            <div class="input-group">
                <label for="level">Select Level Type:</label>
                <select id="level" name="level" style="width: calc(102% - 1px); padding: 12px; border-radius: 6px; border: 1px solid #ccc; background-color:white;">
                    <?php
                        
                        if ($result['level'] == 1) {
                            # code...
                            echo "<option value=\"1\" selected>1</option>";
                            echo "<option value=\"2\">2</option>";
                            echo "<option value=\"3\">3</option>";
                        } elseif ($result['level'] == 2) {
                            # code...
                            echo "<option value=\"1\">1</option>";
                            echo "<option value=\"2\" selected>2</option>";
                            echo "<option value=\"3\">3</option>";
                        } else {
                            # code...
                            echo "<option value=\"1\">1</option>";
                            echo "<option value=\"2\">2</option>";
                            echo "<option value=\"3\" selected>3</option>";
                        }
                    
                    ?>
                </select>
            </div>
            <button type="submit" name="updateQA">update</button>
        </form>
        <br>

        <form method="post">
        <button type="submit" name="back">Back</button>
        </form>
    </div>


    <?php
    
        // Check if the 'insert' form has been submitted
        if(isset($_POST['updateQA'])) {

            // Establish a connection to the database
            $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

            // get and check information from POST method is Empty or no
            $QA_Id = isset($_POST["QA_Id"])? $_POST["QA_Id"]: NULL;
            $question = isset($_POST["question"])? $_POST["question"]: NULL;
            $answer_1 = isset($_POST["answer_1"])? $_POST["answer_1"]: NULL;
            $answer_2 = isset($_POST["answer_2"])? $_POST["answer_2"]: NULL;
            $answer_3 = isset($_POST["answer_3"])? $_POST["answer_3"]: NULL;
            $answer_4 = isset($_POST["answer_4"])? $_POST["answer_4"]: NULL;
            $correct_answer = isset($_POST["correct_answer"])? $_POST["correct_answer"]: NULL;
            $level = isset($_POST["level"])? $_POST["level"]: NULL;

            // check the inputUser is NULL or not
            // if ($question !== "" && $answer_1 != "" && $answer_2 != "" && $answer_3 != "" && $answer_4 != "" && $correct_answer != "" && $level != "") {
                
            //     // Define the SQL query to insert to users table
            //     $query = "UPDATE `qa` SET `question`='$question',`answer_1`='$answer_1',`answer_2`='$answer_2',`answer_3`='$answer_3',`answer_4`='$answer_4',`correct_answer`='$correct_answer',`level`='$level' WHERE `QA_Id`='$QA_Id'";

            //     // Execute the SQL query
            //     $result = mysqli_query($connection, $query);

            //     // close connection to the database
            //     mysqli_close($connection);
                
            //     // Redirect
            //     header("Location: ./manageQA.php");

            //     // Exit the script with a successful status
            //     exit(0);

            // } else {
                
            //     echo "<script>alert('Wrong Update');</script>";
            // }

            // Define the SQL query to update the qa table
            $query = "UPDATE `qa` SET `question`=?, `answer_1`=?, `answer_2`=?, `answer_3`=?, `answer_4`=?, `correct_answer`=?, `level`=? WHERE `QA_Id`=?";

            // Prepare the SQL statement
            $stmt = mysqli_prepare($connection, $query);

            // Bind parameters
            mysqli_stmt_bind_param($stmt, 'sssssssi', $question, $answer_1, $answer_2, $answer_3, $answer_4, $correct_answer, $level, $QA_Id);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            // Close statement and connection
            mysqli_stmt_close($stmt);
            mysqli_close($connection);

            // // Redirect to the index page upon successful login
            header("Location: ./manageQA.php");

            // Exit the script with a successful status
            exit(0);

            
        }
    
    ?>

</body>
</html>
