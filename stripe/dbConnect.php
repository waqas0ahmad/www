<?php  
     $sthost = "localhost";

     $stuser = "123bailamariA";

     $stpassword = "";

     $stdatabase = "waqastestdb";
// Connect with the database  
$db = new mysqli($sthost, $stuser, $stpassword, $stdatabase);  
  
// Display error if failed to connect  
if ($db->connect_errno) {  
    printf("Connect failed: %s\n", $db->connect_error);  
    exit();  
}