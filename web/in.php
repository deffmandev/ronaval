<?php

function mysql($sql)
{
    global $conn;
    return  $conn->query($sql);
}

date_default_timezone_set('Europe/Paris');



if (isset($_POST["test"]))
{
    $test=$_POST["test"];
    $Ip=$_SERVER["REMOTE_ADDR"];
    $Datage=date("Y-m-d");
    $Timage=date("H:i");
    $ValTable=explode(",",$test);

    echo $Ip;
    echo ",";
    echo $Datage;
    echo ",";
    echo $Timage;

$servername = "bonite.o2switch.net:3306"; 
$username   = "jlrx7819_Ronaval";
$dbname     = "jlrx7819_Ronaval";
$password   = "Hxm^B}^0p{4P"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn)
    mysql("INSERT INTO `Dates` (`keys`, `Date`, `heurs`, `Ip`, `S1`, `S2`,`S3`,`S4`,`S5`,`S6`,`S7`,`S8`) VALUES (NULL, '$Datage', '$Timage', '$Ip', '$ValTable[0]' , '$ValTable[1]', '$ValTable[2]', '$ValTable[3]', '$ValTable[4]', '$ValTable[5]', '$ValTable[6]', '$ValTable[7]'  )");

}

?>