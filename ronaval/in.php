<?php
date_default_timezone_set('Europe/Paris');

    $Ip=$_SERVER["REMOTE_ADDR"];
    $Datage=date("Y-m-d");
    $Timage=date("H:i");


if (isset($_POST["test"]))
{
    $test=$_POST["test"];

    $ValTable=explode(",",$test);

    echo $Ip;
    echo ",";
    echo $Datage;
    echo ",";
    echo $Timage;
}
else
{
    $ValTable[0]=11.5;
}

function mysql($sql)
{
    global $conn;
    return  $conn->query($sql);
}

$servername = "bonite.o2switch.net:3306"; // Usually 'localhost' on o2switch
$username = "jlrx7819_Ronaval"; // Your database username
$password = "Hxm^B}^0p{4P"; // Your database password
$dbname = "jlrx7819_Ronaval"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn)
    mysql("INSERT INTO `Dates` (`keys`, `Date`, `heurs`, `Ip`, `S1`, `S2`) VALUES (NULL, '$Datage', '$Timage', '$Ip', '$ValTable[0]' , '$ValTable[1]'  )");

?>