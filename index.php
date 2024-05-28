<?php 
# read in data
$data = file_get_contents("weight_data.csv");
$data_lines = explode("\n", $data);

# data stores
$data = Array();
$data_90_days = Array();
$data_365_days = Array();
$steps = Array();
$step_points = Array(7, 14, 21, 28);

# process it
foreach ( $data_lines AS $data_line ) {
    list($weight, $date) = explode(",", $data_line);

    if ( isset( $data[$date] ) ) {
        echo "<pre>Error: duplicate date, " . $date . "</pre>";
    }

    $data[$date] = $weight;

    if ( strtotime($date) > strtotime("-90 days") ) {
        $data_90_days[$date] = $weight;
    }
    if ( strtotime($date) > strtotime("-365 days") ) {
        $data_365_days[$date] = $weight;
    }

    if ( !isset($current_weight) ) {
        $current_weight = $weight;
    }

    foreach ( $step_points AS $step_point ) {
        if ( strtotime($date) > strtotime("-" . $step_point . " days") AND !isset( $steps[$step_point] ) ) {
            $steps[$step_point] = Array(
                "change" => $current_weight - $weight,
                "weight" => $weight,
                "date" => $date,
            );
        }
    }
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Weight Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/2.4.0/luxon.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-adapter-luxon/1.1.0/chartjs-adapter-luxon.min.js"></script>

    <link href="styles.css" rel="stylesheet" type="text/css" />

    <script>
    function record_it() {
        
        var weight_value = document.getElementById("weight").value;
        var date_value = document.getElementById("date").value;
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "handler.php?weight=" + weight_value + "&date=" + date_value, false);
        xhttp.send();
        document.getElementById("response_place").innerHTML = xhttp.responseText; 
    }
    </script>



</head>
  <body>

    
    <div class="container text-center">
        <div class="row align-items-start">
            <div class="col">
                <h1>Weight Dashboard</h1>
            </div>
        </div>
    </div>

    <hr/>

    <div class="container text-left">
        <div class="row align-items-start">
            <div class="col-4">
                <h2>Record a weight</h2>


                <div class="mb-3">
                    <label for="weight" class="form-label">Weight:</label>
                    <input type="number" id="weight" name="weight" min="40" max="200" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date:</label>
                    <input type="date" id="date" name="date" value="<?php echo date("Y-m-d")?>" class="form-control" />
                </div>
                <button type="submit" class="btn btn-primary" onclick="record_it()">Record it</button>

                <div id="response_place"></div>

                <hr/>

                <h2>Change</h2>

                <?php 
                $steps = array_reverse($steps, TRUE);
                #echo "<pre>" . print_r($steps, TRUE) . "</pre>";
                ?>

                <ul>
                    <?php 
                    

                    foreach ( $steps AS $step => $step_data ) {
                        echo "<li>";
                        echo $step . " days: " . $step_data["change"] . "kg ";
                        echo "(" . $step_data["weight"] . "kg, " . date('l jS \o\f F',  strtotime($step_data["date"]) ) . ")";
                        echo "</li>";

                    }
                    ?>
                </ul>
            </div>

            <div class="col-8">
                <h2>Last 90 Days</h2>
                <div class="chart_box">
                    <canvas id="chart_weight_90_days"></canvas>
                </div>
<script>
new Chart(document.getElementById("chart_weight_90_days"), {
    type: 'line',
    data: {
        labels:  ['<?php echo implode("','", array_keys($data_90_days) ) ?>'],
        datasets: [{
            label: 'Weight',
            data: [<?php echo implode(",", $data_90_days) ?>],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.2
        }]
    },
    options: {
        maintainAspectRatio: false,
        spanGaps: true,
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'DD',
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>


            </div>
        </div>
    </div>


    <hr/>

    <div class="container">
        <div class="row align-items-start">
            <div class="col text-left">
                <h2>Last 365 Days</h2>
                <div class="chart_box">
                    <canvas id="chart_weight_365_days"></canvas>
                </div>
<script>
new Chart(document.getElementById("chart_weight_365_days"), {
    type: 'line',
    data: {
        labels:  ['<?php echo implode("','", array_keys($data_365_days) ) ?>'],
        datasets: [{
            label: 'Weight',
            data: [<?php echo implode(",", $data_365_days) ?>],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.2
        }]
    },
    options: {
        maintainAspectRatio: false,
        spanGaps: true,
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'DD',
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
            </div>
        </div>
    </div>    

    <hr/>

    <div class="container">
        <div class="row align-items-start">
            <div class="col text-left">
                <h2>All Time</h2>
                <div class="chart_box">
                    <canvas id="chart_weight_all_time"></canvas>
                </div>
<script>
new Chart(document.getElementById("chart_weight_all_time"), {
    type: 'line',
    data: {
        labels:  ['<?php echo implode("','", array_keys($data) ) ?>'],
        datasets: [{
            label: 'Weight',
            data: [<?php echo implode(",", $data) ?>],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.2
        }]
    },
    options: {
        maintainAspectRatio: false,
        spanGaps: true,
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'DD',
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
            </div>
        </div>
    </div>





    <div class="container">
        <div class="row align-items-start">
            <div class="col text-left">
                <h2>Raw data array</h2>
            <?php 
                echo "<pre>" . print_r($data, TRUE) . "</pre>";
                ?>
            </div>
            <div class="col text-left">
                <h2>Weight conversions</h2>
                <ul>
                    <li>1 stone = 6.4kg</li>
                    <li>2 stone = 12.7kg</li>
                    <li>3 stone = 19.1kg</li>
                    <li>4 stone = 25.4kg</li>
                    <li>5 stone = 31.8kg</li>
                    <li>6 stone = 38.1kg</li>
                    <li>7 stone = 44.5kg</li>
                    <li>8 stone = 50.8kg</li>
                    <li>9 stone = 57.2kg</li>
                    <li>10 stone = 65.5kg</li>
                    <li>11 stone = 69.9kg</li>
                    <li>12 stone = 76.2kg</li>
                    <li>13 stone = 82.5kg</li>
                    <li>14 stone = 88.9kg</li>
                    <li>15 stone = 95.3kg</li>
                    <li>16 stone = 101.6kg</li>
                </ul>

                <ul>
                    <li>97.2kg = 15.3 stone</li>
                    <li>80kg = 12.6 stone</li>
                    <li>17kg = 2.7 stone</li>
                    <li>63kg = 9.9 stone</li>
                    <li>85.9kg = 13.5 stone</li>
                </ul>
            </div>
            <div class="col text-right">
                <h2>Dates and weights</h2>
                <ul>
                <?php 
                    foreach( $data AS $date => $weight ) {
                        echo "<li>" . $date . ": " . $weight . "kg</li>";
                    }
                ?>
                </ul>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


