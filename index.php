<!-- HEADER.PHP -->
<?php 
  require "header.php"
?>

  <main class="container mt-3" style="width: 1000px">
    <!-- 1. CONDITIONAL Logged In/Logged Out Alerts -->
    <?php 
      // Checks the $_SESSION for user variable
      if(isset($_SESSION['userId'])){
        echo '<div class="alert alert-success" role="alert">You are logged in</div>';
      }
      else
      {
        echo '<div class="alert alert-warning" role="alert">You are not logged in</div>';
      }
    ?>
  </main>
  <main class="container p-4 bg-light mt-3" style="width: 1000px">
    <h4>Welcome to Jumblr Food Blog</h4>
    <div id="home" class="text-center"><img src="./img/table.jpg"  alt="Table Setting"><small class="text-center text-muted d-block my-3">Photo credit: Hannah Bushing</small></div>
  </main>

<!-- FOOTER.PHP -->
<?php 
  require "footer.php"
?>