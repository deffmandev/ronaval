<style>
body 
{
    background-color: #d3d3d3;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 2px;
    margin: auto;
    width: 126%;
}

.imagecta {
    display: block;
    margin: 0 auto;
    max-width: 800;
}

.cadreimage
{
    display: block;
    padding: 15px;
    margin: auto;
    text-shadow: 0 0 5px #ffffff;
}

.Infosonde
{
    font-size: 21px;
    border: 1px solid #9b9b9b;
    color: #FFFFFE;
    text-shadow: 0px 0px 5px black;
    width: 80px;
    border-radius: 13px;
    height: 29px;
    box-shadow: 3px 2px 2px #0000005e;
    display: inline-flex;
    background: #13426780;
    align-items: center;
    justify-content: center;
}

.labelSonde
{
    display: inline-block;
    font-size: 18px;
    width: 49%;
    margin-bottom: 8px;
}

</style>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <title>Interface Ronaval</title>
</head>
<body>
    
</body>
</html>


<?php

//Connection a la base de données
$servername = "bonite.o2switch.net:3306";
$username   = "jlrx7819_Ronaval";
$dbname     = "jlrx7819_Ronaval";   
$password   = "Hxm^B}^0p{4P";
$conn = new mysqli($servername, $username, $password, $dbname); 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}           
$sql = "SELECT * FROM `Dates` ORDER BY `keys` DESC LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

//var_export($row);

echo <<<HTML

<br><br><br><br>

<div class='cadreimage'>
    <span class="labelSonde">Addresse Ip</span>
    <span class="labelSonde" >{$row["Ip"]}</span><br>

    <span class="labelSonde">Dernier Point</span>
    <span class="labelSonde" >{$row["Date"]}  {$row["heurs"]}</span><br>

    <span class="labelSonde">Température Exterieur</span>
    <span class="Infosonde" >{$row["S3"]}°c</span><br>
    
    <span class="labelSonde">Température AirNeuf</span>
    <span class="Infosonde" >{$row["S4"]}°c</span><br>
    
    <span class="labelSonde">Température Reprise</span>
    <span class="Infosonde" >{$row["S5"]}°c</span><br>
    
    <span class="labelSonde">Température Soufflage</span>
    <span class="Infosonde" >{$row["S6"]}°c</span><br>
    
    <span class="labelSonde">Température Entree d'eau</span>
    <span class="Infosonde" >{$row["S7"]}°c</span><br>
    
    <span class="labelSonde">Température Sortie d'eau</span>
    <span class="Infosonde" >{$row["S8"]}°c</span><br>

    <span class="labelSonde">Température Cpu</span>
    <span class="Infosonde" >{$row["S2"]}°c</span><br>

    <span class=labelSonde>Disponibilite de dique</span>
    <span class="Infosonde" >{$row["S1"]}%</span><br>

</div>
HTML;



$conn->close();
?>
