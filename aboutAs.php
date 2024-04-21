<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML CSS Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #303cbf;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        section {
            padding: 20px;
            text-align: center;
        }

        footer {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        nav a {
            display: inline;
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 16px;
        }

        nav a:hover {
            background-color: black;
            color: white;
            
        }

        @media screen and (max-width: 600px) {
            .navbar a {
                display: block;
                text-align: left;
            }
        }
        
    </style>
</head>
<body style="background-color: azure;">

        <?php
        
            // create session
            session_start();

            // check session
            if(!isset($_SESSION['sessionId'])) {
                // redirect
                header("Location: ./login.php");
                exit(0);
            }

        ?>


    <header>
        <h1>Welcome to my Website</h1>
    </header>

    <nav>
        <a href="./index.php">Home</a>
    </nav>

    <section>
        <h2>About Us</h2>
        <p>Welcome to the testing site</p>
    </section>

    <footer>
        <p>&copy; 2024 My Website. All Rights Reserved.</p>
    </footer>
</body>
</html>
