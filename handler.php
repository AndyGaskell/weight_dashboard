<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$weight = floatval($_GET["weight"]);
$date_tick = strtotime($_GET["date"]);
$date = date("Y-m-d", $date_tick);

echo "<br/><div class=\"alert alert-success\" role=\"alert\">Recorded weight " . $weight . "kg for the date " . date("F jS, Y", $date_tick) . ".</div>";

$data_line = "\n" . $weight . "," . $date;

$data_filename = "weight_data.csv";

file_put_contents($data_filename, $data_line, FILE_APPEND);