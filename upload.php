<?php
  if (($_FILES['file']['name'] != "")) {
    // Where the file is going to be stored
    $target_dir = "files/";
    $file = $_FILES['file']['name'];
    $path = pathinfo($file);
    $filename = $path['filename'];
    $ext = $path['extension'];
    $temp_name = $_FILES['file']['tmp_name'];
    $path_filename_ext = $target_dir.$filename.".".$ext;
     
    // Check if file already exists
    if (file_exists($path_filename_ext)) {
      echo "Sorry, file already exists.";
    }else{
      move_uploaded_file($temp_name,$path_filename_ext);
      echo "Congratulations! File Uploaded Successfully.";
    }
  }
?>