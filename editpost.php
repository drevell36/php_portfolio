<!-- HEADER.PHP -->
<?php 
  require "header.php"
?>

  <main class="container p-4 bg-light mt-3" style="width: 1000px">
    <!-- GET DATA SCRIPT -->
    <?php
      if(isset($_SESSION['userId']) && isset($_GET['id'])){
        // Connect to DB
        require './includes/connect.inc.php';

        // Declare $row to store array
        $row;

        // Collect and store GET data and escape the integer
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $id = intval($id);

        // GET post row by ID for Pre-pop (Prepared statements)
        // (i) Declare template SQL with ? placeholder
        $sql = "SELECT title, imageurl, comment, websiteurl, websitetitle FROM posts WHERE id=?";

        // (ii) Init SQL satement 
        $statement = mysqli_stmt_init($conn);

        // (iii) Prepare statement to DB to check for errors
        if(!mysqli_stmt_prepare($statement, $sql))
        {
          // ERROR: Something wrong when preparing SQL
          header("Location: editpost.php?id=$id&error=sqlerror");
          exit();
        } else {
          // (iv) Bind our user data with statement + escape integer
          mysqli_stmt_bind_param($statement, "i", $id);

          // (v) Execute the SQL
          mysqli_stmt_execute($statement);

          // (vi) Return result and store in variable
          $result = mysqli_stmt_get_result($statement);
          $row = mysqli_fetch_assoc($result);

          // STEP 7: Pre populate

        }

      } else {
        header("Location: index.php");
        exit();
      }
    ?>

    <?php
      // DYNAMIC ERROR ALERT FOR EDIT POST
      if(isset($_GET['error'])){
        // (i) Empty fields
        if($_GET['error'] == "emptyfields"){
          $errorMsg = "Please fill in all fields";
        }

        // (ii) Interal server error
        else if($_GET['error'] == "sqlerror"){
          $errorMsg = "An internal server error has occurred - please try again later";

        }
        // (iii) Error alert
        echo '<div class="alert alert-danger" role="alert">' . $errorMsg . '</div>';
      }
      // SUCCESS MESSAGE ON posts.php
    ?>

    <!-- editpost.inc.php - Will process the data from this form-->
    <form action="includes/editpost.inc.php?id=<?php echo $id ?>" method="POST">
      <h2>Edit Post</h2>

      <!-- 1. TITLE -->
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo $row['title'] ?>">
      </div>  

      <!-- 2. IMAGE URL -->
      <div class="mb-3">
        <label for="imageurl" class="form-label">Image URL</label>
        <input type="text" class="form-control" name="imageurl" placeholder="Image URL" value="<?php echo $row['imageurl'] ?>" >
      </div>

      <!-- 3. COMMENT SECTION -->
      <div class="mb-3">
        <label for="comment" class="form-label">Comment</label>
        <textarea class="form-control" name="comment" rows="3" placeholder="Comment"><?php echo $row['comment'] ?></textarea>
      </div>

      <!-- 4. WEBSITE URL -->
      <div class="mb-3">
        <label for="websiteurl" class="form-label">Website URL</label>
        <input type="text" class="form-control" name="websiteurl" placeholder="Website URL" value="<?php echo $row['websiteurl'] ?>" >
      </div>

      <!-- 5. WEBSITE TITLE -->
      <div class="mb-3">
        <label for="websitetitle" class="form-label">Website Title</label>
        <input type="text" class="form-control" name="websitetitle" placeholder="Website Title" value="<?php echo $row['websitetitle'] ?>" >
      </div>

      <!-- 6. SUBMIT BUTTON -->
      <button type="submit" name="edit-submit" class="btn btn-primary w-100">Edit</button>
    </form>
  </main>

<!-- FOOTER.PHP -->
<?php 
  require "footer.php"
?>