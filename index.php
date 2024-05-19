<?php 
$data = file_get_contents("weight_data.csv");
$data_lines = explode("\n", $data);

$data = Array();
$data_90_days = Array();
$data_365_days = Array();


foreach ( $data_lines AS $data_line ) {
    list($weight, $date) = explode(",", $data_line);
    $data[$date] = $weight;
    if ( strtotime($date) > strtotime("-90 days") ) {
        $data_90_days[$date] = $weight;
    }
    if ( strtotime($date) > strtotime("-365 days") ) {
        $data_365_days[$date] = $weight;
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
                <h2>Record it</h2>


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


            </div>

            <div class="col-8">
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
                One of three columns
            </div>
            <div class="col text-left">
                <h2>Weight conversions</h2>
                <ul>
                    <li>10 Stone = 65.5kg</li>
                    <li>11 Stone = 69.9kg</li>
                    <li>12 Stone = 76.2kg</li>
                    <li>13 Stone = 82.5kg</li>
                    <li>14 Stone = 88.9kg</li>
                    <li>15 Stone = 95.3kg</li>
                    <li>16 Stone = 101.6kg</li>
                </ul>
            </div>
            <div class="col text-right">
                <h2>Raw data</h2>
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


