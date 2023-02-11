<?php

    // Check user is logged In and Id (post) passed in via GET
    session_start();
    if(isset($_SESSION['userId']) && isset($_GET['id'])){
        // Connect to DB
        require 'connect.inc.php';

        // Collect and store POST data and escape the integer
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $id = intval($id);

        // Delete post from DB
        // (i) Declare SQL template with ? placeholders
        $sql = "DELETE FROM posts WHERE id=?";

        // (ii) Init SQL statement
        $statement = mysqli_stmt_init($conn);

        // (iii) Prepare statement to DB to check for errors
        if(!mysqli_stmt_prepare($statement, $sql))
        {
        // ERROR: Something wrong when preparing SQL
        header("Location: ../posts.php?id=$id&error=sqlerror");
        exit();
        } else {
            // (iv) Bind our user data 
            mysqli_stmt_bind_param($statement, "i", $id);

            // (v) Execute the SQL
            mysqli_stmt_execute($statement);

            // (vi) SUCCESS: Post
            header("Location: ../posts.php?id&delete=success");
        }

    // Restrict access to script
    } else {
        header("Location: ../signup.php");
    }   

?>