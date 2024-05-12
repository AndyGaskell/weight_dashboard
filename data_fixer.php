<?php 

$data = file_get_contents("weight_data_mod_01.txt");


$data_lines = explode("\n", $data);

$data_out = "";

foreach ( $data_lines AS $data_line ) {

    list($weight, $date) = explode(" - ", $data_line);

    echo "line: " . $data_line . "\n";
    echo "weight 1: " . $weight . "\n";
    $weight = str_replace("kg", "", $weight);
    $weight = floatval($weight);
    echo "weight 2: " . $weight . "\n";

    echo "date 1: " . $date . "\n";
    $date_tick = strtotime($date);
    $date = date("Y-m-d", $date_tick);
    echo "date 2: " . $date . "\n";

    echo " \n";

    $data_out .= "\n" . $weight . "," . $date;
}

echo " \n";
echo $data_out;