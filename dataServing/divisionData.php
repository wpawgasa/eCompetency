

<?php
header("Content-Type: text/html; charset=utf-8");
//mb_internal_encoding("UTF-8");
$host="localhost:8889";
$user="root";
$pass="root";
$db="competency_db";
$dbhandle = mysql_connect($host, $user,$pass) 
  or die("Unable to connect to MySQL");
//echo "Connected to MySQL<br>";
mysql_select_db($db);
$sql = "SELECT * FROM division";

//echo "p'jack ";
mysql_query("SET NAMES utf8 ");
$result = mysql_query ($sql);

//echo "error".mysql_error();

$b = array();
while ( $row= mysql_fetch_array ( $result ) )       
{
    //print_r($row);
    //echo"p'mui";
   $a = new stdClass();
   $a->division_id=$row["division_id"]; 
   $a->division_name=$row["division_name"]; 
   $a->division_code= $row["division_code"];
   $a->division_group= $row["division_group"];

   //$tmpName=iconv("UTF-8","ISO-8859-1",$name);
   array_push($b, $a);
}
echo json_encode(array("data"=>$b));
?>