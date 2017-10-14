<?php
$target_dir = "fileuploads/";
print_r($_FILES);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["tmp_name"]);
echo "target file is ". $target_file;
//$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file is a csv file
if(isset($_POST["submit"])) {
   echo 'File uploaded successfully.';
   $fileName=$_FILES["fileToUpload"]["name"];
   move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'fileuploads/' . $_FILES["fileToUpload"]["name"]);
}
?>