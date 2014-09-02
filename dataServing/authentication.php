
<?php

header("Content-Type: text/html; charset=utf-8");
//mb_internal_encoding("UTF-8");
$host = "localhost:8889";
$user = "root";
$pass = "root";
$db = "competency_db";
$dbhandle = mysql_connect($host, $user, $pass)
        or die("Unable to connect to MySQL");
//echo "Connected to MySQL<br>";
mysql_select_db($db);

$username = $_REQUEST['user'];
$password = md5($_REQUEST['pwd']);

$sql = "SELECT * FROM user where username='$username' AND password='$password' AND status='0'";
mysql_query("SET NAMES utf8 ");
$result = mysql_query($sql);
if (mysql_errno() != 0) {
    echo json_encode(array("data" => null, "success" => 0, "error" => mysql_error()));
} else {
    if (mysql_num_rows($result) > 0) {
        echo json_encode(array("data" => null, "success" => 1, "error" => null));
    } else {
        echo json_encode(array("data" => null, "success" => 0, "error" => "Username or password is incorrect"));
    }
}
//echo "error".mysql_error();
?>