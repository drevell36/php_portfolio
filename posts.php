<!-- HEADER.PHP -->
<?php 
  require "header.php"
?>

  <main class="container p-4 bg-light mt-3" style="width: 1000px">
  <?php
    // SETUP INITIAL POSTS QUERY
    // (i) Connect to DB
    require './includes/connect.inc.php';

    // (ii) Declare our SQL command to DB
    // NOTE: This will retrieve ALL rows from "posts" table
    $sql = "SELECT id, title, imageurl, comment, websiteurl, websitetitle FROM posts";

    // (iii) Call SQL query and store result in variable
    $result = mysqli_query($conn, $sql);

  ?>

  <!-- Dynamic Success Alert - createpost.inc.php -->
  <?php
    // DYNAMIC SUCCESS MESSAGE FOR POST CREATION
    if(isset($_GET['post']) == "success"){
      echo '<div class="alert alert-success" role="alert">Post created!</div>';
    }

    // DYNAMIC SUCCESS MESSAGE FOR EDIT
    if(isset($_GET['edit']) == "success"){
      echo '<div class="alert alert-success" role="alert">Post edited!</div>';
    }

    // DYNAMIC SUCCESS/ERROR MESSAGE FOR POST DETECTION 
    if(isset($_GET['error'])){
      if($_GET['error'] == "sqlerror") {
        $errorMsg= "An internal server error has occured - please try again later";
      }

      // Dynamic Error Alert
      echo '<div class="alert alert-danger" role="alert">' . $errorMsg . '</div>';

      // Display Success Message
    } else if(isset($_GET['delete']) == "success"){
      echo '<div class="alert alert-success" role="alert">Post successfully deleted</div>';
    }

  ?>
  <!-- DYNAMIC POSTS OUTPUT -->
  <?php
    // CHECK FOR POSTS RETURNED IN RESULT AND DISPLAY ON SUCCESS
    if(mysqli_num_rows($result) > 0){
      // 3. LOOP DATA INTO OUR BOOTSTRAP CARD AND THE LOOPING THE CARD ITSELF
      // (i) New variable with default state
      $output = "";

      // (ii) Take $result -> convert to an array -> insert into a While loop
      while($row = mysqli_fetch_assoc($result)) {
        // (iv) Joined output cards together .=
        $output .= 
        '<div class="card border-0 mt-3" id="' . $row['id'] . '">
          <img src="' . $row['imageurl'] . '" class="card-img-top post-image" alt="' . $row['title'] .'">
          <div class="card-body">
            <h5 class="card-title">' . $row['title'] . '</h5>
            <p class="card-text">' . $row['comment'] . '</p>
            <a href="' . $row['websiteurl'] .'" class="btn btn-primary w-100">' . $row['websitetitle'] . '</a>';

          if(isset($_SESSION['userId'])){
            $output .= '
            <div class="admin-btn">
              <a href="editpost.php?id=' . $row['id'] . '" class="btn btn-secondary mt-2">Edit</a>
              <a href="includes/deletepost.inc.php?id=' . $row['id'] . '" class="btn btn-danger mt-2">Delete</a>
            </div>
            ';
          }

        $output .= ' 
          </div>
        </div>';
      }

      // (iii) Echo out the result of loop
      echo $output;

    } else {
      // Lazy Option
      echo "0 results";

      // Advanced option: Info message "Looks like you have not posted anything - go here to create your first post" (Make sure to wrap createpost.php in issest($_SESSION['userid'])
    }
    mysqli_close($conn);
  ?>
    
  </main>

<!-- FOOTER.PHP -->
<?php 
  require "footer.php"
?>