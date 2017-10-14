<?php
$target_dir = "/fileuploads";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file is a csv file
if(isset($_POST["submit"])) {
   echo 'File uploaded successfully.';
   $fileName=$_FILES["fileToUpload"]["name"];
   echo $fileName;
}
?>