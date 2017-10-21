<?php

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);


//To load display.php to display contents
class Manage {
    public static function autoload($class) {
        include 'index.php';
    }
}

spl_autoload_register(array('Manage', 'autoload'));

//instantiate the program object

Class uploads{
 static public function uploadFile(){                                                    //to move file into target directory
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
       display::printThis($text);                                                        //to display the message
     }
   }
   else{
     $text= 'Upload csv File';
     display::printThis($text);                                                          //to display the message
        }
   
    }
  }
}


$obj = new main();


class main {

    public function __construct()
    {
        //set default page request to homepage
        $pageRequest = 'homepage';
        //check if there are parameters
        if(isset($_REQUEST['page'])) {
            //load the type of page the request wants into page request
            $pageRequest = $_REQUEST['page'];
        }
        //instantiate the class that is being requested
         $page = new $pageRequest;


        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $page->get();
        } else {
            $page->post();
        }

    }

}

abstract class page {
    protected $html='';
    public function __construct()
    {
        //Starting html form
        $this->html .= '<html>';
        $this->html .= '<body>';
        display::printThis($this->html);

    }
    public function __destruct()
    {
        $this->html = '</body></html>';
        display::printThis($this->html);
    }

    public function get() {
         $html='Into Abstract class Page';
        display::printThis($html);
    }

    public function post() {
        print_r($_POST);
    }
}

class homepage extends page
{

    public function get()
    {
        //form to take csv file as input
        $form='';
        $form .='<center>';
        $form .= '<form action="index.php?page=homepage" method="post" enctype="multipart/form-data">';
        $form .='<h3>Upload CSV File</h3><br>';
        $form .= '<input type="file" name="fileToUpload" id="fileToUpload"><br><br>';
        $form .= '<input type="submit" value="Upload CSV file" name="submit"></center>';
        $form .= '</form> ';
        display::printThis($form);                                                        //display form
        

    }

    public function post() {
        uploads::uploadFile();
            }
            
}

class displayTable extends page {

public function get(){
//extracting file name from url
$csvFile=$_REQUEST["filename"];
$form='';
$row = 1;
//opening file from directory
if (($handle = fopen("filesuploads/".$csvFile, "r")) !== FALSE) {
    
    //table display
    $form.= '<table border="1">';
    
    while (($data = fgetcsv($handle)) !== FALSE) {
        $num = count($data);
        if ($row == 1) {
            $form .='<style>thead th {background-color:grey}</style><tr>';
            $form.='<thead><tr>';
        }else{
            $form .= '<tr>';
        }
        
        for ($col=0; $col < $num; $col++) {
            if(!isset($data[$col])) {
               $value = "&nbsp;";
            }else{
               $value = $data[$col];
            }
            if ($row == 1) {
                $form .= '<th>'.$value.'</th>';
            }else{
                $form .= '<td>'.$value.'</td>';
            }
          }
        
        if ($row == 1) {
            $form .= '</tr></thead><tbody>';
        }else{
            $form .= '</tr>';
        }
        $row++;
      }
    
    $form .= '</tbody></table>';
    display::printThis($form);                                                          //to print table
    fclose($handle);                                                                    //closing opened file
    }
  }
}

class display{
	static public function printThis($text){
		echo $text;
	}
}

?>