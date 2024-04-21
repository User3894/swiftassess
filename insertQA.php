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
            header("Location: ./manageQA.php");
            exit(0);
        }

        // store userInput
        $question;
        $answer_1;
        $answer_2;
        $answer_3;
        $answer_4;
        $correct_answer;
        $level;

        // store query
        $query;

        // Establish a connection to the database
        $connection = mysqli_connect("sql307.infinityfree.com", "if0_36394046", "6gST4T4H3NV", "if0_36394046_quiz");

        // Define the SQL query to insert to users table
        //$query = "INSERT INTO `users`(`userName`, `userPassword`, `userEmail`, `userPhone`, `userPerm`, `userDept`) VALUES ('$userName','$userPassword','$userEmail','$userPhone','$userPermission','$userDepart')";

        // Check if the 'insert' form has been submitted
        if(isset($_POST['insert'])) {


            // get and check information from POST method is Empty or no
            $question = isset($_POST["question"])? $_POST["question"]: NULL;
            $answer_1 = isset($_POST["answer_1"])? $_POST["answer_1"]: NULL;
            $answer_2 = isset($_POST["answer_2"])? $_POST["answer_2"]: NULL;
            $answer_3 = isset($_POST["answer_3"])? $_POST["answer_3"]: NULL;
            $answer_4 = isset($_POST["answer_4"])? $_POST["answer_4"]: NULL;
            $correct_answer = isset($_POST["correct_answer"])? $_POST["correct_answer"]: NULL;
            $level = isset($_POST["level"])? $_POST["level"]: NULL;

            // check the inputUser is NULL or not
            if (isset($question) && isset($answer_1) && isset($answer_2) && isset($answer_3) && isset($answer_4) && isset($correct_answer) && isset($level)) {
                
                // Define the SQL query to insert to users table
                $query = "INSERT INTO `qa`(`question`, `answer_1`, `answer_2`, `answer_3`, `answer_4`, `correct_answer`, `level`) VALUES ('$question','$answer_1','$answer_2','$answer_3', '$answer_4','$correct_answer', '$level')";

                // Execute the SQL query
                $result = mysqli_query($connection, $query);

                // close connection to the database
                mysqli_close($connection);

                // clear variable
                $question = NULL;
                $answer_1 = NULL;
                $answer_2 = NULL;
                $answer_3 = NULL;
                $answer_4 = NULL;
                $correct_answer = NULL;
                $level = NULL;

                // Output success message
                echo "<script>alert('Enter successful');</script>";
            } else {
                
                echo "<script>alert('Wrong entry');</script>";
            }

            
        }
    ?>
    <div class="login-container" style="width:600px; padding-top: 300px">
        
        <h2>Insert QA</h2>

        <form method="post">
            <div class="input-group">
                <label for="question">question</label>
                <input type="text" id="question" name="question" placeholder="Enter your question" style="height:50px">
            </div>
            <div class="input-group">
                <label for="answer_1">answer_1</label>
                <input type="text" id="answer_1" name="answer_1" placeholder="Enter your answer_1" style="height:50px">
            </div>
            <div class="input-group">
                <label for="answer_2">answer_2</label>
                <input type="text" id="answer_2" name="answer_2" placeholder="Enter your answer_2" style="height:50px">
            </div>
            <div class="input-group">
                <label for="answer_3">answer_3</label>
                <input type="text" id="answer_3" name="answer_3" placeholder="Enter your answer_3" style="height:50px">
            </div>
            <div class="input-group">
                <label for="answer_4">answer_4</label>
                <input type="text" id="answer_4" name="answer_4" placeholder="Enter your answer_4" style="height:50px">
            </div>
            <div class="input-group">
                <label for="correct_answer">Select correct_answer:</label>
                <input type="text" id="correct_answer" name="correct_answer" placeholder="Enter your correct_answer" style="height:50px">
            </div>
            <div class="input-group">
                <label for="level">Select Level Type:</label>
                <select id="level" name="level" style="width: calc(102% - 1px); padding: 12px; border-radius: 6px; border: 1px solid #ccc; background-color:white;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
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
