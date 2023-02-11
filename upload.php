<?php 
  require "header.php";
  // Declare general variables initial states
  $directory = 'uploads';
  $uploadOk = 1;
  $the_message = '';
  $the_message_ext = '';

  // Declare PHP upload error scenarios
  $phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
  );

  // Save upload data to variables
  if(isset($_POST['submit'])){
    $temp_name = $_FILES['fileToUpload']['tmp_name'];
    $target_file = $_FILES['fileToUpload']['name'];
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $my_url = $directory . DIRECTORY_SEPARATOR . $target_file;

    // PHP Custom Errors
    $the_error = $_FILES['fileToUpload']['error'];
    if($_FILES['fileToUpload']['error'] != 0){
      $the_message_ext = $phpFileUploadErrors[$the_error];
      $uploadOk = 0;
    }

    // Set custom error handlers
    // (1) FILE ALREADY EXISTS
    if($the_message_ext == "" && file_exists($my_url)){
      $the_message_ext = "The file already exists, please save as a different name or upload a different file";
      $uploadOk = 0;
    }

    // (2) INCORRECT FILE EXTENSION
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
      $the_message_ext = "File type is not allowed, please choose a jpg, png, jpeg or gif";
      $uploadOk = 0;
    }

    // Set our main error capture & success Upload case
    if($uploadOk == 0) {
      $the_message = "<p>Sorry, your file was not uploaded.</p>" . "<strong>Error: </strong>" . $the_message_ext;
    } else {
      if(move_uploaded_file($temp_name, $directory . "/" . $target_file)){
        $the_message = "File uploaded successfully. " . 'Preview it here: <a href="' .$my_url . '" target="_blank">' . $my_url . '</a>';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- External CSS -->
  <link rel="stylesheet" href="./styles.css">
  <title>Uploader</title>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-8">

        <!-- A. File Upload Form: START -->
        <form action="upload.php" method="POST" enctype="multipart/form-data">
          <p class="lead">Select image to upload:</p>

          <div class="input-group mb-3">     
            <!-- File Input -->
            <input type="file" class="form-control" id="inputGroupFile" name="fileToUpload">
            <!-- Submit Button -->
            <input type="submit" value="Upload" name="submit" class="btn btn-primary input-group-text"></input>
          </div>

        </form>
        <!-- File Upload Form: START -->

        <!-- Alert Message -->
        <?php
        if($the_message == ""){
          echo null;
        }
         else if($uploadOk == 0){
          echo '<div class="alert alert-danger" role="alert">' . $the_message . '</div>';
        } else {
          echo '<div class="alert alert-success" role="alert">' . $the_message . '</div>';
        }
        ?>
        </div>
      </div>
    </div>
  </div> 

<!-- FOOTER.PHP -->
<?php 
  require "footer.php"
?> 

</body>
</html>