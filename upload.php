<?php
class Manage {
    public static function autoload($class) {
        //to display contents on page
        include 'display.php';
    }
}

spl_autoload_register(array('Manage', 'autoload'));
$target_dir = "filesuploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["tmp_name"]);
$fileName=$_FILES["fileToUpload"]["name"];
$FileType = pathinfo($fileName,PATHINFO_EXTENSION);
//checking file type
if(isset($_POST["submit"])) {
   if($FileType=="csv"){                                                                                                              
     //checking existance of file
     if(!file_exists("filesuploads/".$_FILES["fileToUpload"]["name"])){                                                              
       move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'filesuploads/' . $_FILES["fileToUpload"]["name"]);
       header("Location: http://web.njit.edu/~sp2339/project1/index.php?page=displayTable&filename=".$_FILES["fileToUpload"]["name"]);
     }
     else{
       $text= 'File already exists';
       display::printThis($text);
     }
   }
   else{
     $text= 'Upload csv File';
     display::printThis($text);
        }
   
}
?>