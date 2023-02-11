<?php 
    session_start();

    if(isset($_POST['post-submit']) && isset($_SESSION['userId'])){
        // Connect to DB
        require 'connect.inc.php';

        // Collect and store POST data
        $title = $_POST['title'];
        $imageURL = $_POST['imageurl'];
        $comment = $_POST['comment'];
        $websiteURL = $_POST['websiteurl'];
        $websiteTitle = $_POST['websitetitle'];

        // Validation: Check for errors
        // (i) Empty fields
        if(empty($title) || empty($imageURL) || empty($comment) || empty($websiteTitle)) {
            // ERROR: Redirect and error via GET
            header("Location ../createpost.php?error=emptyfields");
            exit();

        // Save our Post to DB using prepared statements
        } else {
            // (i) Declare our Template SQL using ? placeholders
            $sql = "INSERT INTO posts VALUES (NULL, ?, ?, ?, ?, ?)";

            // (ii) Init statement 
            $statement = mysqli_stmt_init(($conn));

            // (iii) Prepare and send statement to DB to check for errors
            if(!mysqli_stmt_prepare($statement, $sql)) {
                header("Location ../createpost.php?error=sqlerror");
                exit();
            } else {
                // (iv) Bind our user data with the statement and escape strings in process
                // NOTE: FIVE strings
                mysqli_stmt_bind_param($statement, "sssss", $title, $imageURL, $comment, $websiteURL, $websiteTitle);
                
                // (v) Execute the SQL statement with user data
                mysqli_stmt_execute($statement);

                //(vi) SUCCESS: Post is saved and redirect with success
                header("Location: ../posts.php?post=success");
                exit();
            }
        }

    } else {
        header("Location ../index.php");
    }

?>