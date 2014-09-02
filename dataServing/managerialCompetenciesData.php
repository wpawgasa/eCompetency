
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
$sql = "SELECT * FROM competencies where competency_group='2'";
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
   $a->id=$row["id"]; 
   $a->name= $row["competency_name"];
   $a->group= $row["competency_group"];
   $a->maxvalue=$row["competency_max_level"];
   $a->division=$row["competency_in_division"];
   //$tmpName=iconv("UTF-8","ISO-8859-1",$name);
   array_push($b, $a);
 //echo "<br> ข้อมูล : $tmpName <br> ";
 
}
echo json_encode(array("data"=>$b));
?>